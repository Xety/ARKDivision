<?php

namespace Xetaravel\Http\Controllers\Donation;

use GuzzleHttp\Client;
use GuzzleHttp\Command\Exception\CommandClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;
use RestCord\DiscordClient;
use Xetaravel\Events\Badges\DonationEvent;
use Xetaravel\Events\Donation\NewDonationEvent;
use Xetaravel\Http\Controllers\Controller;
use Xetaravel\Models\Repositories\AccountRepository;
use Xetaravel\Models\Repositories\PaypalUserRepository;
use Xetaravel\Models\Repositories\TransactionUserRepository;
use Xetaravel\Models\Repositories\UserRepository;
use Xetaravel\Models\Role;
use Xetaravel\Models\User;

class PaypalController extends Controller
{

    /**
     * Validation errors messages
     *
     * @var array
     */
    private $customMessages = [
        'required' => 'Le champs :attribute est requis.',
        'between' => 'La :attribute doit être comprise entre 5€ et 300€.',
        'numeric' => 'La valeur du champs :attribute doit être numéric.',
        'regex' => 'Le format du champs :attribute est invalide.',
        'min' => 'Votre message doit comporter au moins 5 caractères.',
        'max' => 'Votre message doit comporter moins de 200 caractères.'
    ];

    /**
     * Handle a checkout request before redirecting to Paypal.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkout(Request $request)
    {
        $discord = $request->input('discord');
        $donation = $request->input('donation');
        $message = $request->input('message');

        // Validate the data.
        $data = $request->validate([
            'discord' => [
                'required',
                'regex:/^\d+$|^[anonymous]+$/i'
            ],
            'donation' => [
                'required',
                'numeric',
                'between:5,300',
                // Check if donation is a multiple of 5.
                function ($attribute, $value, $fail) {
                    if ($value % 5 != 0) {
                        $fail('Le champs ' . $attribute . ' doit être un multiple de 5.');
                    }
                },
            ],
            'message' => [
                'required',
                'min:5',
                'max:200'
            ],
        ], $this->customMessages);

        // Check if the user has not modified the input "discord".
        if ($discord != "anonymous") {
            // If the user is not authenticated.
            if (!Auth::check()) {
                return redirect()->back()->with(
                    'danger',
                    'Vous n\'êtes pas connecté avec votre compte Division.'
                );
            }

            // If the user has not linked his Discord and Division accounts.
            if (is_null(Auth::user()->discord_id)) {
                return redirect()->back()->with(
                    'danger',
                    ' Vous n\'avez pas lié votre Discord à votre compte Division.'
                );
            }

            $user = Auth::user();
            $discord = new DiscordClient(['token' => config('discord.bot.token')]);

            try {
                $member = $discord->guild->getGuildMember([
                    'guild.id' => config('discord.guild.id'),
                    'user.id' => $user->discord_id
                ]);
            } catch (CommandClientException $e) {
                $member = null;
            }

            // The user is not on our Discord anymore or has not a valid Discord ID.
            if (is_null($member)) {
                return redirect()->back()->with(
                    'danger',
                    'Vous n\'êtes plus présent sur le discord de ARK Division ou une erreur est survenu' .
                    'lors de la récupération du compte via Discord, veuillez contacter un administrateur sur discord.'
                );
            }
        }

        // Live
        /*$apiContext = new ApiContext(
            new OAuthTokenCredential(
                'AQKS69kpyM_1NuMP3WPFqmfNTPBNJIVKilpY-eMV4Rvk0qYjDjf8BHqYUeUs1pWkTWci1qrbJ23UNWek',     // ClientID
                'EExTSko5nKF-o7n_yJ58ndyMUS-F-tZFO6SwsNMo3KFuDYkt2lkSC2SjHXYac18YgHMtx7JQM5lj6bMy'      // ClientSecret
            )
        );
        $apiContext->setConfig([
            'mode' => 'live'
        ]);*/

        // Sandbox
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                'AcIUDaNhHuI9c2TPHdJfknSVhNGhtkXTMwBLOiRMzQVlajP9zJ-xkFuQEuW5KicPGvAYfJpSgkV42nkl',     // ClientID
                'ENs3pI02g-g8t8ZOstpQIKh-3rETScck4ruS596cdCUm7JzcumWve-7Nvl6fFCJX33_DzJShr1SH-hXg'      // ClientSecret
            )
        );

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item = new Item();
        $item->setName('Donation')
            ->setCurrency('EUR')
            ->setQuantity(1)
            ->setPrice($donation);

        $itemList = new ItemList();
        $itemList->setItems([$item]);

        $amount = new Amount();
        $amount->setTotal($donation)
            ->setCurrency('EUR');

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList);

        if ($discord != "anonymous") {
            $transaction->setCustom(json_encode(['user_id' => $member->user->id, 'message' => $message]));
        } else {
            $transaction->setCustom(json_encode(['user_id' => "anonymous", 'message' => $message]));
        }

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('donation.paypal.redirect'))
            ->setCancelUrl(route('donation.page.index'));

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions([$transaction])
            ->setRedirectUrls($redirectUrls);

        if ($discord != "anonymous") {
            $payment->setNoteToPayer('Récompense pour ' . $member->user->username . '#' . $member->user->discriminator);
        }

        try {
            $payment->create($apiContext);
        } catch (PayPalConnectionException $e) {
            throw new PayPalConnectionException(
                'An error occured while creating the Paypal payment : ' . $e->getData()
            );
        }
        return redirect($payment->getApprovalLink());
    }

    /**
     * Handle the response from Paypal after a payment.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect(Request $request)
    {
        // Live
        /*$apiContext = new ApiContext(
            new OAuthTokenCredential(
                'AQKS69kpyM_1NuMP3WPFqmfNTPBNJIVKilpY-eMV4Rvk0qYjDjf8BHqYUeUs1pWkTWci1qrbJ23UNWek', // ClientID
                'EExTSko5nKF-o7n_yJ58ndyMUS-F-tZFO6SwsNMo3KFuDYkt2lkSC2SjHXYac18YgHMtx7JQM5lj6bMy' // ClientSecret
            )
        );

        $apiContext->setConfig([
            'mode' => 'live'
        ]);*/

        // Sandbox
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                'AcIUDaNhHuI9c2TPHdJfknSVhNGhtkXTMwBLOiRMzQVlajP9zJ-xkFuQEuW5KicPGvAYfJpSgkV42nkl', // ClientID
                'ENs3pI02g-g8t8ZOstpQIKh-3rETScck4ruS596cdCUm7JzcumWve-7Nvl6fFCJX33_DzJShr1SH-hXg' // ClientSecret
            )
        );

        $paymentId = $request->paymentId;
        $payment = Payment::get($paymentId, $apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($request->PayerID);

        try {
            $result = $payment->execute($execution, $apiContext);
        } catch (Exception $e) {
            Log::error($e);
            throw new Exception('The Paypal payment execution has failed : ' . $e->getMessage());
        }

        // Check if the payment is approved.
        if ($result->state != 'approved') {
            return redirect()->route('donation.paypal.success')->with(
                'danger',
                'Votre paiement n\'a pas été accepté, veuillez contacter un administrateur pour plus d\'information.'
            );
        }

        $custom = json_decode($result->transactions[0]->custom);

        // Check if the user is not "anonymous"
        if ($custom->user_id != "anonymous") {
            $user = User::where('discord_id', $custom->user_id)->first();

            // Get the Discord nformations for this user.
            $discord = new DiscordClient(['token' => config('discord.bot.token')]);

            try {
                $member = $discord->guild->getGuildMember([
                    'guild.id' => config('discord.guild.id'),
                    'user.id' => $user->discord_id
                ]);
            } catch (CommandClientException $e) {
                // The user is not on our Discord anymore or has not a valid Discord ID.
                Log::error($e);
                throw new CommandClientException(
                    'The user is not on our Discord anymore or has not a valid Discord ID'
                );
            }

            // Get or create the paypal
            $paypal = PaypalUserRepository::getOrCreate([
                'user_id' => $user->id,
                'email' => $result->payer->payer_info->email,
                'first_name' => $result->payer->payer_info->first_name,
                'last_name' => $result->payer->payer_info->last_name,
                'payer_id' => $result->payer->payer_info->payer_id,
                'country_code' => $result->payer->payer_info->country_code
            ]);

            // Create the transaction
            $transaction = TransactionUserRepository::create([
                'user_id' => $user->id,
                'paypal_id' => $paypal->id,
                'payment_id' => $result->id,
                'amount' => $result->transactions[0]->amount->total,
                'currency' => $result->transactions[0]->amount->currency,
                'custom' => json_encode([
                    'description' => $result->transactions[0]->description,
                    'discord_id' => $custom->user_id
                ])
            ]);

            // We must get the user again due to the count fields being updated.
            $user = User::where('discord_id', $custom->user_id)->with('Paypal', 'Roles')->first();

            // Update the Skins and Colors
            $amount = $result->transactions[0]->amount->total;

            // We need to remove the current amount from the amount total due to the update of the paypal before.
            $amountTotal = $user->paypal->amount_total - $amount;

            $skins = $this->getCount($amount, $user->skin_count, $amountTotal, 'skin');
            $colors = $this->getCount($amount, $user->color_count, $amountTotal, 'color');

            UserRepository::updateDonation([
                'color_remain' => $user->color_remain + $colors,
                'skin_remain' => $user->skin_remain + $skins,
                'color_count' => $user->color_count + $colors,
                'skin_count' => $user->skin_count + $skins
            ], $user);

            // Update the user role.
            $role = Role::where('slug', 'membre')->first();
            // Update the role only if the user has a lower level of his role related to the `membre` role (level 2)
            if ($user->level() < 2) {
                $user->syncRoles([$role->id]);
            }

            // Update or create the account with related discord fields.
            AccountRepository::updateDiscord([
                'discord_username' => $member->user->username,
                'discord_discriminator' => $member->user->discriminator
            ], $user->id);

            // Create the rewards for the user.
            $rewards = $this->getCount($amount, $user->reward_count, $amountTotal, 'reward');
            if ($rewards >= 1) {
                event(new NewDonationEvent($user, $rewards));
            }

            // Handle donation badges event.
            event(new DonationEvent($user));

            // Generate the message to send to Discord.
            $description = "**" . $paypal->fullName . "** (<@" . $user->discord_id .
            ">) vient de faire une donation de **" . $transaction->amount . $transaction->currency .
            "** !\n\n**Son message** : " . $custom->message;
        } else {
            // Generate the message to send to Discord.
            $description = "**Un anonyme**  vient de faire une donation de **" .
            $result->transactions[0]->amount->total . $result->transactions[0]->amount->currency .
            "** !\n\n**Son message** : " . $custom->message . "\n";
        }

        // Send the message to the #logs-bot channel.
        $discord = new DiscordClient(['token' => config('discord.bot.token')]);

        $discord->channel->createMessage([
            'channel.id' => config('discord.channels.logs-bot'),
            'embed' => [
                'description' => $description,
                'color' => hexdec("1DFCEA"),
                'thumbnail' => [
                    'url' => 'https://cdn.discordapp.com/app-icons/635391187301433380/'.
                    '1816aec0f6a4418f7ed19773e97dfb98.png'
                ],
                'author' => [
                    'name' => 'Donation Paypal',
                    'icon_url' => 'https://cdn.discordapp.com/attachments/631999661112033280/'.
                    '744946610169053364/pp258.png'
                ]
            ]
        ]);

        // Check if the user is not "anonymous" before to send the command.
        if ($custom->user_id != "anonymous") {
            $name = "<@" . $user->discord_id . "> ";

            $text =  <<<EOT
*Un grand merci à* **✦ $name ✦** *pour son généreux don au serveur*   **ARK DIVISION FRANCE**

***  ✦        Ce don donne accès        ✦***
```yaml
= Au statut  - Membre -  en vert sur Discord, qui permet de participer aux votes concernant les
grandes décisions de nos serveurs
= Au statut  -   DJ   -  donnant des droits prioritaires sur les bots musique
= Statut valable 6 mois, renouvelable à la demande si actif sur nos serveurs```
```asciidoc
= A une couleur personnalisée sur le dino de ton choix tous les 10€ de dons```
```fix
A un skin ou émote du jeu offert pour toutes les tranches de 20€
```
```css
[ De modifier et personnaliser son nom de tribu sur Discord ]
```
```diff
- A l'outil ARKLog de Division qui vous permet d'accéder à vos informations de tribu en tout temps et de n'importe où !
```

*Pour faire une demande de couleur et/ou de skin, il vous suffit de taper `-demande couleur` et/ou `-demande skin` dans
le chat <#386615163165605891> du discord. Vous pouvez également utiliser la commande `-inventaire` pour voir combien de
couleurs/skins il vous reste.  Pour plus d'information sur l'outil ARKLog : <#693371861307752468>*
EOT;

            $discord->channel->createMessage([
                'channel.id' =>
                (env('APP_ENV') == 'local') ? config('discord.channels.logs-bot') : config('discord.channels.general'),
                'content' => $text
            ]);
        }

        return redirect()->route('donation.paypal.success');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function success(Request $request)
    {
        return view('donation.paypal.success');
    }

    /**
     *  Get the number of the type relative to the donation amount.
     *
     * @param int $amount The donation amount.
     * @param int $countTotal The total colors/skins/rewards of the member.
     * @param int $amountTotal The total amount since the beginning.
     * @param string $type The type of rewards to count. `skin` , `color` or `reward`
     *
     *  @return int The number of the type that the user is allowed to use.
     */
    protected function getCount(int $amount, int $countTotal, int $amountTotal, string $type = null) : int
    {
        // We count the donation related to the type count total.
        $donationForTotal = config('xetaravel.donation.' . $type . '_interval') * $countTotal;

        // We soustrac the amount total from the total type amount.
        $remain = $amountTotal - $donationForTotal;

        // We addition the remain and the new donation.
        $amount = $remain + $amount;

        $count = 0;

        while ($amount >= config('xetaravel.donation.' . $type . '_interval')) {
            $count++;
            $amount = $amount - config('xetaravel.donation.' . $type . '_interval');
        }

        return $count;
    }
}

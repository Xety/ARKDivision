<?php

namespace Division\Http\Controllers;

use Division\Models\Repositories\PaypalRepository;
use Division\Models\Repositories\TransactionRepository;
use Division\Models\Repositories\UserRepository;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
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
        'min' => 'Votre message doit comporter au moins 5 caractères.'
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function checkout(Request $request)
    {
        $discord = $request->input('discord');
        $donation = $request->input('donation');
        $message = $request->input('message');

        $data = $request->validate([
            'discord' => [
                'required',
                'regex:/^\d+$|^[nope]+$/i'
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
                'min:5'
            ],
        ], $this->customMessages);

        // Check Discord ID.
        if ($discord != "nope") {
            $client = new Client();
            $res = $client->request(
                'GET',
                'https://discordapp.com/api/v6/guilds/386615163165605889/members/' . $discord,
                [
                    'headers' => [
                        'Authorization' => 'Bot NjM2NTYzNTM0NzE2NjAwMzMx.XeOK9Q.rLR_7aoW1sm4tIQ6Fg58hGbSy5s',
                    ]
                ]
            );
            $user = json_decode($res->getBody());

            if (!$user) {
                return redirect()->back()->with(
                    'danger',
                    'Cet utilisateur n\'est plus présent sur le discord de ARK Division ou une erreur est survenu' .
                    'lors de la récupération du compte via discord, veuillez contacter un administrateur sur discord.'
                );
            }
        }

        // Live
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                'AQKS69kpyM_1NuMP3WPFqmfNTPBNJIVKilpY-eMV4Rvk0qYjDjf8BHqYUeUs1pWkTWci1qrbJ23UNWek',     // ClientID
                'EExTSko5nKF-o7n_yJ58ndyMUS-F-tZFO6SwsNMo3KFuDYkt2lkSC2SjHXYac18YgHMtx7JQM5lj6bMy'      // ClientSecret
            )
        );
        $apiContext->setConfig([
            'mode' => 'live'
        ]);

        // Sandbox
        /*$apiContext = new ApiContext(
            new OAuthTokenCredential(
                'AcIUDaNhHuI9c2TPHdJfknSVhNGhtkXTMwBLOiRMzQVlajP9zJ-xkFuQEuW5KicPGvAYfJpSgkV42nkl',     // ClientID
                'ENs3pI02g-g8t8ZOstpQIKh-3rETScck4ruS596cdCUm7JzcumWve-7Nvl6fFCJX33_DzJShr1SH-hXg'      // ClientSecret
            )
        );*/

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

        if ($discord != "nope") {
            $transaction->setCustom(json_encode(['user_id' => $user->user->id, 'message' => $message]));
        } else {
            $transaction->setCustom(json_encode(['user_id' => "nope", 'message' => $message]));
        }

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('paypal.redirect'))
            ->setCancelUrl(route('page.index'));

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions([$transaction])
            ->setRedirectUrls($redirectUrls);

        if ($discord != "nope") {
            $payment->setNoteToPayer('Récompense pour ' . $user->user->username . '#' . $user->user->discriminator);
        }

        try {
            $payment->create($apiContext);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getData();
        }
        return redirect($payment->getApprovalLink());
    }

    /**
     *
     */
    public function redirect(Request $request)
    {
        // Live
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                'AQKS69kpyM_1NuMP3WPFqmfNTPBNJIVKilpY-eMV4Rvk0qYjDjf8BHqYUeUs1pWkTWci1qrbJ23UNWek', // ClientID
                'EExTSko5nKF-o7n_yJ58ndyMUS-F-tZFO6SwsNMo3KFuDYkt2lkSC2SjHXYac18YgHMtx7JQM5lj6bMy' // ClientSecret
            )
        );

        $apiContext->setConfig([
            'mode' => 'live'
        ]);

        // Sandbox
        /*$apiContext = new ApiContext(
            new OAuthTokenCredential(
                'AcIUDaNhHuI9c2TPHdJfknSVhNGhtkXTMwBLOiRMzQVlajP9zJ-xkFuQEuW5KicPGvAYfJpSgkV42nkl', // ClientID
                'ENs3pI02g-g8t8ZOstpQIKh-3rETScck4ruS596cdCUm7JzcumWve-7Nvl6fFCJX33_DzJShr1SH-hXg' // ClientSecret
            )
        );*/

        $paymentId = $request->paymentId;
        $payment = Payment::get($paymentId, $apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($request->PayerID);

        try {
            $result = $payment->execute($execution, $apiContext);
        } catch (Exception $ex) {
            Log::error($ex);
            exit(1);
        }

        if ($result->state == 'approved') {
            $custom = json_decode($result->transactions[0]->custom);

            // Check if the user is not "nope"
            if ($custom->user_id != "nope") {
                //Get or create the user
                $user = UserRepository::create([
                    'discord_user_id' => $custom->user_id
                ]);

                // Get or create the paypal
                $paypal = PaypalRepository::create([
                    'user_id' => $user->id,
                    'email' => $result->payer->payer_info->email,
                    'first_name' => $result->payer->payer_info->first_name,
                    'last_name' => $result->payer->payer_info->last_name,
                    'payer_id' => $result->payer->payer_info->payer_id,
                    'country_code' => $result->payer->payer_info->country_code
                ]);

                // Create the transaction
                $transaction = TransactionRepository::create([
                    'user_id' => $user->id,
                    'paypal_id' => $paypal->id,
                    'payment_id' => $result->id,
                    'amount' => $result->transactions[0]->amount->total,
                    'currency' => $result->transactions[0]->amount->currency,
                    'custom' => json_encode([
                        'description' => $result->transactions[0]->description,
                        'discord_user_id' => $custom->user_id
                    ])
                ]);

                $description = "**\n" . $paypal->fullName . "** (<@" . $user->discord_user_id .
                ">) vient de faire une donation de **" . $transaction->amount . $transaction->currency .
                "** !\n\n**Son message** : " . $custom->message;
            } else {
                $description = "**\nUn anonyme**  vient de faire une donation de **" .
                $result->transactions[0]->amount->total . $result->transactions[0]->amount->currency .
                "** !\n\n**Son message** : " . $custom->message . "\n";
            }


            // Webhook discord bot
            $webhookObject = json_encode([
                "username" => "ARK Division",
                "avatar_url" => "https://cdn.discordapp.com/app-icons/635391187301433380/" .
                "1816aec0f6a4418f7ed19773e97dfb98.png",
                "tts" => false,
                "embeds" => [
                    [
                        "description" => $description,
                        "type" => "rich",
                        "color" => hexdec("1DFCEA"),
                        "thumbnail" => [
                            "url" => "https://cdn.discordapp.com/app-icons/635391187301433380/" .
                            "1816aec0f6a4418f7ed19773e97dfb98.png"
                        ]
                    ]
                ]
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

            $client = new Client();
            $res = $client->request(
                'POST',
                'https://discordapp.com/api/webhooks/635914645240152074/' .
                'YVbI-rdbKr3IpJW3jjEYKm5xfnFy7Tysd9QL9N0F9q7IpLgekQ5PzHmuMB9pTQwz2LMn',
                [
                    'body' => $webhookObject,
                    'headers' => [
                        'Length' => strlen($webhookObject),
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bot NjM2NTYzNTM0NzE2NjAwMzMx.XeOK9Q.rLR_7aoW1sm4tIQ6Fg58hGbSy5s',
                    ]
                ]
            );

            // Fix for a bug where the bot send message int he wrong channel.
            sleep(2);

            // Check if the user is not "nope" before to send to the -don command.
            if ($custom->user_id != "nope") {
                $text = "-don <@" . $user->discord_user_id . "> " . (int) $transaction->amount;

                $webhookObject = json_encode([
                    "username" => "ARK Division",
                    "avatar_url" => "https://cdn.discordapp.com/app-icons/635391187301433380/" .
                    "1816aec0f6a4418f7ed19773e97dfb98.png",
                    "tts" => false,
                    "content" => $text
                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

                $res = $client->request(
                    'POST',
                    'https://discordapp.com/api/webhooks/722190658529656892/' .
                    '55b3-jaeOxj2BCachzF_uLMi5cwJQSNWn_sjoT0Gd7Ymm08yVQy4ugMqkVJiPI_-btVK',
                    [
                        'body' => $webhookObject,
                        'headers' => [
                            'Length' => strlen($webhookObject),
                            'Content-Type' => 'application/json',
                            'Authorization' => 'Bot NjM2NTYzNTM0NzE2NjAwMzMx.XeOK9Q.rLR_7aoW1sm4tIQ6Fg58hGbSy5s',
                        ]
                    ]
                );
            }

            return redirect()->route('paypal.success');
        } else {
            // Payment is not appoved
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function success(Request $request)
    {
        return view('paypal.success');
    }
}

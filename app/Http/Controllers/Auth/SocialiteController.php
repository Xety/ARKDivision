<?php
namespace Xetaravel\Http\Controllers\Auth;

use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as ProviderUser;
use Symfony\Component\HttpFoundation\RedirectResponse as RedirectResponseSF;
use Xetaravel\Events\Badges\RegisterEvent;
use Xetaravel\Http\Controllers\Controller;
use Xetaravel\Models\User;
use Xetaravel\Models\Repositories\AccountRepository;
use Xetaravel\Models\Repositories\UserRepository;
use Xetaravel\Models\Role;
use Xetaravel\Models\Validators\UserValidator;

class SocialiteController extends Controller
{
    use RedirectsUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * The driver used.
     *
     * @var string
     */
    protected $driver;

    /**
     * Show the registration form.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * @param string $driver The driver used.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showRegistrationForm(Request $request, string $driver)
    {
        if (is_null($request->session()->get('socialite.driver'))) {
            return redirect()
                ->route('users.auth.login')
                ->with('danger', 'Vous n\'êtes pas autorisé à afficher cette page !');
        }
        return view('Auth.socialite', compact('driver'));
    }

    /**
     * Register an user that has been forced to modify his email or
     * username due to a conflit with the database.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * @param string $driver The driver used.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request, string $driver): RedirectResponse
    {
        $this->driver = $driver;
        $validator = UserValidator::createWithProvider($request->all());

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput($request->all());
        }
        $user = Socialite::driver($driver)->userFromToken($request->session()->get('socialite.token'));

        $user->name = $request->input('username');
        $user->email = $request->input('email');

        $user = $this->registered($user);

        $request->session()->forget('socialite');

        return $this->login($request, $user);
    }

    /**
     * Redirect the user to the Provider authentication page.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * @param string $driver The driver used.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider(Request $request, string $driver): RedirectResponseSF
    {
        return Socialite::driver($driver)
                ->setScopes(['identify', 'email'])
                ->redirectUrl(route('auth.driver.callback', ['driver' => $driver]))
                ->redirect();
    }

    /**
     * Obtain the user information from the Provider and process to the
     * registration or login regarding to the type of callback.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * @param string $driver The driver used.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback(Request $request, string $driver): RedirectResponse
    {
        $this->driver = $driver;

        try {
            $user = Socialite::driver($driver)->user();
        } catch (Exception $e) {
            $driver = Str::title($driver);

            return redirect()
                ->route('users.auth.login')
                ->with('danger', "Une erreur s'est produite lors de l'obtention de vos informations de {$driver} !");
        }

        // Check if the user is already registered
        if (!$member = User::where($driver . '_id', $user->id)->first()) {
            $register = $this->handleRegister($request, $user);
        }

        if (isset($register) && $register instanceof RedirectResponse) {
            return $register;
        } elseif (!isset($register) || !$register instanceof User) {
            $register = $member;
        }

        return $this->login($request, $register);
    }

    /**
     * Login the user and trigger the authenticated function.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * @param \Xetaravel\Models\User $user The user to login.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function login(Request $request, User $user): RedirectResponse
    {
        Auth::login($user, true);

        $this->authenticated($request, $user);

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Handle the registration.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * @param \Laravel\Socialite\Two\User $user The user to register.
     *
     * @return \Illuminate\Http\RedirectResponse|\Xetaravel\Models\User
     */
    protected function handleRegister(Request $request, ProviderUser $user)
    {
        $validator = UserValidator::createWithProvider([
            'username' => $user->name,
            'email' => $user->email
        ]);

        if ($validator->fails()) {
            $request->session()->put('socialite', [
                'driver' => $this->driver,
                'token' => $user->token
            ]);

            return redirect()
                ->route('auth.driver.register', ['driver' => $this->driver])
                ->withErrors($validator)
                ->withInput([
                    'username' => $user->name,
                    'email' => $user->email
                ]);
        }

        $user = $this->registered($user);

        return $user;
    }

    /**
     * Create the user.
     *
     * @param \Laravel\Socialite\Two\User $user The user to create.
     *
     * @return \Xetaravel\Models\User
     */
    protected function createUser(ProviderUser $user)
    {
        return UserRepository::create(
            [
                'username' => $user->name,
                'email' => $user->email
            ],
            [
                $this->driver . '_id' => $user->id
            ],
            true
        );
    }

    /**
     * The user has been authenticated.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * @param \Xetaravel\Models\User $user The user that has been logged in.
     *
     * @return void
     */
    protected function authenticated(Request $request, $user)
    {
        event(new RegisterEvent($user));

        $request->session()->flash(
            'success',
            'Bon retour parmis nous <strong>' . e($user->username) . '</strong>! Vous êtes connecté avec succès!'
        );
    }

    /**
     * The user has been registered.
     *
     * @param \Laravel\Socialite\Two\User $providerUser The user that has been registered.
     *
     * @return \Xetaravel\Models\User
     */
    protected function registered(ProviderUser $providerUser): User
    {
        event(new Registered($user = $this->createUser($providerUser)));

        AccountRepository::updateDiscord([
            'discord_username' => $providerUser->user['username'],
            'discord_discriminator' => $providerUser->user['discriminator']
        ], $user->id);

        $role = Role::where('slug', 'utilisateur')->first();
        $user->attachRole($role);

        if (is_null($providerUser->avatar)) {
            // Set the default avatar.
            $user->addMedia(resource_path('assets/images/avatar.png'))
                ->preservingOriginal()
                ->setName(substr(md5($user->username), 0, 10))
                ->setFileName(substr(md5($user->username), 0, 10) . '.png')
                ->withCustomProperties(['primaryColor' => '#B4AEA4'])
                ->toMediaCollection('avatar');
        } else {
            $user->clearMediaCollection('avatar');
            $user->addMediaFromUrl($providerUser->avatar)
                ->preservingOriginal()
                ->setName(substr(md5($user->username), 0, 10))
                ->setFileName(substr(md5($user->username), 0, 10) . '.png')
                ->toMediaCollection('avatar');
        }




        return $user;
    }
}

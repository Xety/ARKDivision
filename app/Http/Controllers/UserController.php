<?php
namespace Xetaravel\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Xetaravel\Models\Repositories\UserRepository;
use Xetaravel\Models\User;
use Xetaravel\Models\Validators\UserValidator;

class UserController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $action = Route::getFacadeRoot()->current()->getActionMethod();
    }

    /**
     * Show the user profile page.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $slug The slug of the user.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(Request $request, string $slug)
    {
        $user = User::where('slug', Str::lower($slug))->first();

        /*$badges = $user->badges()->get()->groupBy('type');
        dd($badges);*/

        if (is_null($user)) {
            return redirect()
                ->route('page.index')
                ->with('danger', 'Cet utilisateur n\'existe pas ou a été supprimé!');
        }
        $breadcrumbs = $this->breadcrumbs->addCrumb(
            e($user->username),
            $user->profile_url
        );

        return view('user.show', compact('user', 'breadcrumbs'));
    }

    /**
     * Show the transactions.
     *
     * @return \Illuminate\View\View
     */
    public function transactions(): View
    {
        $user = User::find(Auth::id());

        $transactions = $user->transactions()
            ->paginate(config('xetaravel.pagination.transaction.transaction_per_page'));

        $breadcrumbs = $this->breadcrumbs;

        return view(
            'user.transactions',
            compact('user', 'breadcrumbs', 'transactions')
        );
    }

    /**
     * Show the settings form.
     *
     * @return \Illuminate\View\View
     */
    public function showSettingsForm(): View
    {
        $this->breadcrumbs->addCrumb('Paramètres', route('users.user.settings'));

        return view('user.settings', ['breadcrumbs' => $this->breadcrumbs]);
    }

    /**
     * Handle an update request for the user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $type = $request->input('type');

        switch ($type) {
            case 'email':
                return $this->updateEmail($request);

            case 'password':
                return $this->updatePassword($request);

            case 'newpassword':
                return $this->createPassword($request);

            default:
                return back()
                    ->withInput()
                    ->with('danger', 'Type invalide.');
        }
    }

    /**
     * Handle the delete request for the user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if (!Hash::check($request->input('password'), $user->password)) {
            return redirect()
                ->route('users.user.settings')
                ->with('danger', 'Vos mots de passe ne correspondent pas !');
        }
        Auth::logout();

        if ($user->delete()) {
            return redirect()
                ->route('page.index')
                ->with('success', 'Votre compte a été supprimé avec succès !');
        }

        return redirect()
            ->route('page.index')
            ->with('danger', 'Une erreur s\'est produite lors de la suppression de votre compte !');
    }

    /**
     * Show informations about the user.
     *
     * @return \Illuminate\View\View
     */
    public function member(): View
    {
        $user = User::find(Auth::id());

        $breadcrumbs = $this->breadcrumbs;

        return view('user.member', compact('breadcrumbs', 'user'));
    }

    /**
     * Handle a E-mail update request for the user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateEmail(Request $request): RedirectResponse
    {
        UserValidator::updateEmail($request->all())->validate();
        UserRepository::updateEmail($request->all(), Auth::user());

        return redirect()
            ->route('users.user.settings')
            ->with('success', 'Votre e-mail a été mis à jour avec succès !');
    }

    /**
     * Handle a Password update request for the user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updatePassword(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if (!Hash::check($request->input('oldpassword'), $user->password)) {
            return redirect()
                ->route('users.user.settings')
                ->with('danger', 'Vos mots de passe ne correspondent pas !');
        }

        UserValidator::updatePassword($request->all())->validate();
        UserRepository::updatePassword($request->all(), $user);

        return redirect()
            ->route('users.user.settings')
            ->with('success', 'Votre mot de passe a été mis à jour avec succès !');
    }

    /**
     * Handle a Password create request for the user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function createPassword(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if (!is_null($user->password)) {
            return redirect()
                ->route('users.user.settings')
                ->with('danger', 'Vous avez déjà défini un mot de passe.');
        }

        UserValidator::createPassword($request->all())->validate();
        UserRepository::createPassword($request->all(), $user);

        return redirect()
            ->route('users.user.settings')
            ->with('success', 'Votre mot de passe a été créé avec succès !');
    }
}

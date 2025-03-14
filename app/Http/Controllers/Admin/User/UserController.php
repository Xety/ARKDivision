<?php
namespace Xetaravel\Http\Controllers\Admin\User;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Xetaravel\Events\Events\EvenementEvent;
use Xetaravel\Events\Events\RewardLabyrintheTatie;
use Xetaravel\Events\Events\RewardNakor;
use Xetaravel\Http\Controllers\Admin\Controller;
use Xetaravel\Models\Badge;
use Xetaravel\Models\Repositories\UserRepository;
use Xetaravel\Models\Repositories\AccountRepository;
use Xetaravel\Models\User;
use Xetaravel\Models\Role;
use Xetaravel\Models\Validators\UserValidator;

class UserController extends Controller
{
    /**
     * Show the search page.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $latestUsers = User::with(['roles', 'account'])
            ->limit(10)
            ->latest()
            ->get();

        $breadcrumbs = $this->breadcrumbs->addCrumb('Gérer les Utilisateurs', route('admin.user.user.index'));

        return view('Admin::User.user.index', compact('latestUsers', 'breadcrumbs'));
    }
    /**
     * Search users related to the type.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\View\View
     */
    public function search(Request $request): View
    {
        $query = User::with(['roles'])->select();
        $search = str_replace('%', '\\%', trim($request->input('search')));
        $type = trim($request->input('type'));

        switch ($type) {
            case 'username':
                $query->where('username', 'like', '%' . $search . '%');
                break;

            case 'discord_id':
                $query->where('discord_id', 'like', '%' . $search . '%');
                break;

            case 'steam_id':
                $query->where('steam_id', 'like', '%' . $search . '%');
                break;

            case 'email':
                $query->where('email', 'like', '%' . $search . '%');
                break;

            case 'register_ip':
                $query->where('register_ip', 'like', '%' . $search . '%');
                break;

            case 'last_login_ip':
                $query->where('last_login_ip', 'like', '%' . $search . '%');
                break;

            default:
                $query->where('username', 'like', '%' . $search . '%');
                $type = 'username';
                break;
        }
        $users = $query
            ->paginate(10)
            ->appends($request->except('page'));

        $breadcrumbs = $this->breadcrumbs
            ->addCrumb('Gérer les Utilisateurs', route('admin.user.user.index'))
            ->addCrumb('Rechercher un Utilisateur', route('admin.user.user.search'));

        return view('Admin::User.user.search', compact('users', 'breadcrumbs', 'type', 'search'));
    }

    /**
     * Show the update form.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $slug The slug of the user.
     * @param int $id The id of the user.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showUpdateForm(Request $request, string $slug, int $id)
    {
        $user = User::findOrFail($id);

        $roles = Role::pluck('name', 'id');
        $attributes = Role::pluck('id')->toArray();

        $optionsAttributes = [];
        foreach ($attributes as $attribute) {
            $optionsAttributes[$attribute] = [
                'style' => Role::where('id', $attribute)->select('css')->first()->css
            ];
        }

        $breadcrumbs = $this->breadcrumbs
            ->setListElementClasses('breadcrumb breadcrumb-inverse bg-inverse mb-0')
            ->addCrumb('Gérer les Utilisateurs', route('admin.user.user.index'))
            ->addCrumb(
                'Editer ' . e($user->username),
                route('admin.user.user.update', $user->slug, $user->id)
            );

        // Get all events badges to generate the buttons.
        $badgesEvent = Badge::where('type', 'eventParticipating')->get();

        return view(
            'Admin::User.user.update',
            compact('user', 'roles', 'optionsAttributes', 'breadcrumbs', 'badgesEvent')
        );
    }

    /**
     * Handle an user update request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id The id of the user to update.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        UserValidator::update($request->all(), $user->id)->validate();
        UserRepository::update($request->all(), $user);
        $account = AccountRepository::update($request->get('account'), $user->id);

        $user->roles()->sync($request->get('roles'));

        return redirect()
            ->back()
            ->with('success', 'Cet utilisateur a été mis à jour avec succès !');
    }

    /**
     * Handle the delete request for the user.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id The id of the user to delete.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        if (!Hash::check($request->input('password'), Auth::user()->password)) {
            return redirect()
                ->back()
                ->with('danger', 'Votre mot de passe ne correspond pas !');
        }

        if ($user->delete()) {
            return redirect()
                ->route('admin.user.user.index')
                ->with('success', 'Cet utilisateur a été supprimé avec succès !');
        }

        return redirect()
            ->route('admin.user.user.index')
            ->with('danger', 'Une erreur s\'est produite lors de la suppression de cet utilisateur !');
    }

    /**
     * Unlock the badge for the user.
     *
     * @param int $user_id The id of the user.
     * @param int $badge_id The id of the badge.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unlockBadge(int $user_id, int $badge_id): RedirectResponse
    {
        $user = User::findOrFail($user_id);
        $badge = Badge::findOrFail($badge_id);

        // Check if the user has already the badge.
        if ($badge->hasUser($user)) {
            return redirect()
                ->back()
                ->with('danger', 'Cet utilisateur à déjà débloqué ce badge!');
        }

        // Check if the badge is an event badge.
        if ($badge->type != 'eventParticipating') {
            return redirect()
                ->back()
                ->with('danger', 'Ce badge n\'est pas un badge d\'event!');
        }

        // Check if the user has set a Steam ID because there're rewards in the ArkShop.
        if ($badge->slug == 'eventlabyrinthetatie') {
            if (is_null($user->steam_id)) {
                return redirect()
                    ->back()
                    ->with(
                        'danger',
                        'L\'utilisateur n\'a pas de Steam ID, il faut un Steam ID pour les rewards dans le ArkShop.'
                    );
            }
        }

        // Unlock the badge related to the slug of the badge.
        event(new EvenementEvent($user, $badge->slug));

        // Unlock the rewards for the Nakor badge only.
        if ($badge->slug == 'eventnakor') {
            event(new RewardNakor($user));
        }

        // Unlock the rewards for the Le Labyrinthe de Tatie badge.
        if ($badge->slug == 'eventlabyrinthetatie') {
            event(new RewardLabyrintheTatie($user));
        }

        return redirect()
            ->back()
            ->with('success', "Le badge {$badge->name} a bien été débloqué pour cet utilisateur.");
    }

    /**
     * Delete the avatar for the specified user.
     *
     * @param int $id The id of the user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAvatar(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $user->clearMediaCollection('avatar');
        $user->addMedia(resource_path('assets/images/avatar.png'))
            ->preservingOriginal()
            ->setName(substr(md5($user->username), 0, 10))
            ->setFileName(substr(md5($user->username), 0, 10) . '.png')
            ->toMediaCollection('avatar');

        return redirect()
            ->back()
            ->with('success', 'L\'avatar a été supprimé avec succès !');
    }
}

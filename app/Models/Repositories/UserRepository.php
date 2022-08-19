<?php
namespace Xetaravel\Models\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request as FacadeRequest;
use Xetaravel\Models\User;

class UserRepository
{
    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data The data used to create the user.
     * @param array $providerData The additional data provided by the provider.
     * @param bool $provider Whether the user is registered with a Social Provider.
     *
     * @return \Xetaravel\Models\User
     */
    public static function create(array $data, array $providerData = [], bool $provider = false): User
    {
        $ip = FacadeRequest::ip();

        $user = [
            'username' => $data['username'],
            'email' => $data['email'],
            'register_ip' => $ip,
            'last_login_ip' => $ip,
            'last_login' => new \DateTime()
        ];

        if ($provider === false) {
            $user += [
                'password' => bcrypt($data['password'])
            ];
        } else {
            $user += $providerData;
        }

        return User::create($user);
    }

    /**
     * Update the user informations after a valid update request.
     *
     * @param array $data The data used to update the user.
     * @param \Xetaravel\Models\User $user The user to update.
     *
     * @return bool
     */
    public static function update(array $data, User $user): bool
    {
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->discord_id = $data['discord_id'];
        $user->steam_id = $data['steam_id'];

        return $user->save();
    }

    /**
     * Update the user's email after a valid email update.
     *
     * @param array $data The data used to update the user.
     * @param \Xetaravel\Models\User $user The user to update.
     *
     * @return bool
     */
    public static function updateEmail(array $data, User $user): bool
    {
        $user->email = $data['email'];

        return $user->save();
    }

    /**
     * Update the user's password after a valid password update.
     *
     * @param array $data The data used to update the user.
     * @param \Xetaravel\Models\User $user The user to update.
     *
     * @return bool
     */
    public static function updatePassword(array $data, User $user): bool
    {
        $user->password = Hash::make($data['password']);

        return $user->save();
    }

    /**
     * Create the user's password after a valid password create. (For Discord Users)
     *
     * @param array $data The data used to update the user.
     * @param \Xetaravel\Models\User $user The user to update.
     *
     * @return bool
     */
    public static function createPassword(array $data, User $user): bool
    {
        $user->password = Hash::make($data['password']);

        return $user->save();
    }

    /**
     * Update the user skins and colors fields after a valid donation.
     *
     * @param array $data The data used to update the user.
     * @param \Xetaravel\Models\User $user The user to update.
     *
     * @return bool
     */
    public static function updateDonation(array $data, User $user): bool
    {
        $user->skin_count = $data['skin_count'];
        $user->skin_remain = $data['skin_remain'];
        $user->color_count = $data['color_count'];
        $user->color_remain = $data['color_remain'];
        $user->member_expire_at = Carbon::now()->modify(config('division.donation.expire'));

        return $user->save();
    }

    /**
     * Update the user steam id.
     *
     * @param array $data The data used to update the user.
     * @param \Xetaravel\Models\User $user The user to update.
     *
     * @return bool
     */
    public static function updateSteam(array $data, User $user): bool
    {
        // Access ARKLog 48H
        if ($user->arklog_free == false) {
            $user->arklog_free = true;

            // Check if it's not an UNLINK action
            if (!is_null($data['steam_id'])) {
                if (is_null($user->member_expire_at)) {
                    $user->member_expire_at = Carbon::now()->modify(config('division.arklog.expire'));
                } else {
                    // The user has already an member_expire_at, just add arklog.expire to it.
                    $user->member_expire_at = Carbon::create($user->member_expire_at)
                                                                            ->modify(config('division.arklog.expire'));
                }
            }
        }

        $user->steam_id = $data['steam_id'];

        return $user->save();
    }

    /**
     * Update the user discord id.
     *
     * @param array $data The data used to update the user.
     * @param \Xetaravel\Models\User $user The user to update.
     *
     * @return bool
     */
    public static function updateDiscord(array $data, User $user): bool
    {
        $user->discord_id = $data['discord_id'];

        return $user->save();
    }

    /**
     * Update the user twitch id.
     *
     * @param array $data The data used to update the user.
     * @param \Xetaravel\Models\User $user The user to update.
     *
     * @return bool
     */
    public static function updateTwitch(array $data, User $user): bool
    {
        $user->twitch_id = $data['twitch_id'];

        return $user->save();
    }

    /**
     * Find the notifications data for the notification sidebar.
     *
     * @param int $userId The id of the user.
     *
     * @return array
     */
    public static function notificationsData($userId): array
    {
        $user = User::find($userId);

        return [
            'notifications' => $user->notifications()->take(6)->get(),
            'hasUnreadNotifications' => $user->unreadNotifications->isNotEmpty(),
            'unreadNotificationsCount' => $user->unreadNotifications->count()
        ];
    }
}

<?php

namespace Xetaravel\Http\Controllers\API;

use Carbon\Carbon;
use Xetaravel\Http\Resources\Json;
use Xetaravel\Models\User;

class BotUpdaterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Xetaravel\Http\Resources\Json
     */
    public function index()
    {
        $users = User::where('member_expire_at', '>', Carbon::now())
            ->where('steam_id', '!=', null)
            ->select(['slug', 'member_expire_at', 'steam_id'])
            ->get();

        $users  = $users->makeHidden([
            'slug',
            'profile_background',
            'profile_url',
            'avatar_small',
            'avatar_medium',
            'avatar_big',
            'avatar_primary_color',
            'first_name',
            'last_name',
            'full_name',
            'discord_nickname',
            'steam_nickname',
            'biography',
            'signature',
            'facebook',
            'twitter',
            'media',
            'account'
        ]);

        return new Json($users);
    }
}

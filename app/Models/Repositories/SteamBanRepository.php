<?php
namespace Xetaravel\Models\Repositories;

use Illuminate\Support\Collection;
use Xetaravel\Models\SteamBan;

class SteamBanRepository
{
    /**
     * Create a new steam ban and save it.
     *
     * @param array $data The data used to create the steam ban.
     *
     * @return \Xetaravel\Models\SteamBan
     */
    public static function create(array $data) : SteamBan
    {
        return SteamBan::create([
            'steam_id' => (int)$data['steam_id'],
            'banned_by' => (int)$data['banned_by'],
            'forever' => $data['forever'],
            'reason' => $data['reason'],
            'expire_at' => $data['expire_at']
        ]);
    }
}

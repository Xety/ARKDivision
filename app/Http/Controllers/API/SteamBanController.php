<?php

namespace Xetaravel\Http\Controllers\API;

use Illuminate\Http\Request;
use Xetaravel\Http\Resources\Json;
use Xetaravel\Models\Repositories\SteamBanRepository;
use Xetaravel\Models\SteamBan;

class SteamBanController extends Controller
{
    /**
     *  Get a user by his discord id.
     *
     * @param int $id The discord id of the user.
     *
     * @return \Xetaravel\Http\Resources\Json
     */
    public function index(int $id)
    {
        $ban = SteamBan::where('steam_id', $id)
            ->orderBy('created_at', 'desc')
            ->first();

        return new Json($ban);
    }

    /**
     * Create the new Steam ban and save it.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Xetaravel\Http\Resources\Json
     */
    public static function create(Request $request)
    {
        $data = $request->all();
        unset($data['api_token']);

        $steamBan = SteamBanRepository::create($data);

        return new Json($steamBan);
    }

    /**
     *  Get a user by his discord id.
     *
     * @param int $id The discord id of the user.
     *
     * @return \Xetaravel\Http\Resources\Json
     */
    public function checkBan(int $id)
    {
        $ban = SteamBan::where('steam_id', $id)
            ->orderBy('forever', 'asc')
            ->orderBy('created_at', 'desc')
            ->first();

        return new Json($ban);
    }
}

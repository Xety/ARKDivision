<?php

namespace Xetaravel\Http\Controllers\API;

use Illuminate\Http\Request;
use Xetaravel\Http\Resources\Json;
use Xetaravel\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new UserController(Server::all());
    }

    /**
     *  Get a user by his discord id.
     *
     * @param int $id The discord id of the user.
     *
     * @return \Xetaravel\Http\Resources\Json
     */
    public function getByDiscord(int $id)
    {
        $user = User::where('discord_id', $id)->first();

        return new Json($user);
    }

    /**
     *  Update a user by his discord id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id The discord id of the user.
     *
     * @return \Xetaravel\Http\Resources\Json
     */
    public function updateByDiscord(Request $request, int $id)
    {
        $user = User::where('discord_id', $id)->first();

        $data = $request->all();

        unset($data['api_token']);

        foreach ($data as $key => $value) {
            $user->{$key} = $value;
        }

        $user->save();

        return new Json($user);
    }
}

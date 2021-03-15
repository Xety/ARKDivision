<?php

namespace Xetaravel\Http\Controllers\API;

use Illuminate\Http\Request;
use Xetaravel\Http\Resources\Json;
use Xetaravel\Models\Server;

class ServerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servers = Server::all()->makeVisible(['ip', 'rcon_port', 'password']);

        return new Json($servers);
    }

    /**
     * Display the specified resource.
     *
     * @param  string $slug The slug of the server.
     * @return \Illuminate\Http\Response
     */
    public function show(string $slug)
    {
        $server = Server::where('slug', $slug)->first();

        return new Json($server);
    }
}

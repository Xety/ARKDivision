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
        return new ServerResource(Server::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \Xetaravel\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function show(Server $server)
    {
        return new Json($server);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Xetaravel\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Server $server)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Xetaravel\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function destroy(Server $server)
    {
        //
    }
}

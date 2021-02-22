<?php

namespace Xetaravel\Http\Controllers\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Xetaravel\Http\Resources\Json;
use Xetaravel\Models\Server;
use Xetaravel\Models\Status;
use Xetaravel\Models\Repositories\ServerRepository;
use Xetaravel\Models\Validators\ServerStatusValidator;

class ServerStatusController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $slug The slug used to identify the server to update.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $slug)
    {
        $server = Server::where('slug', Str::slug($slug))->first();

        if (is_null($server)) {
            return new Json([
                'message' => 'Server not found.',
                'error' => 404
                ]);
        }

        if ($server->status->type == $request->input('type') ||
            $request->input('type') == 'unknown') {
            return new Json(['message' => 'Type unknown']);
        }

        ServerStatusValidator::create($request->all())->validate();

        $data = [
            'status_id' => $server->status->id,
            'pivot_id' => $server->status->pivot->id,
            'was_forced' => false,
            'finished_at' => Carbon::now()
        ];
        $pivot = ServerRepository::updatePivot($data, $server);

        // Get the status related to the rcon status
        $status = Status::where(['type' => $request->input('type')])->first();

        // Create a new status for this server.
        $server->statutes()->attach($status->id, [
            'event_type' => 'discord'
        ]);

        return new Json([
            'message' => 'The status has been updated successfully !'
        ]);
    }
}

<?php

namespace Xetaravel\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Xetaravel\Models\Server;

class ServerStatusController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $slug The slug used to identify the server to update.
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $slug)
    {
        $slug = Str::slug($slug);

        return response()->json([
            'server' => $slug
        ]);
    }
}

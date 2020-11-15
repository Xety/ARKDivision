<?php

namespace Xetaravel\Http\Controllers\API;

use Illuminate\Http\Request;
use Xetaravel\Http\Resources\Json;
use Xetaravel\Models\Repositories\TicketRepository;
use Xetaravel\Models\Ticket;

class TicketController extends Controller
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
        $ticket = Ticket::where('discord_id', $id)->first();

        return new Json($ticket);
    }

    /**
     * Create the new ticket and save it.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Xetaravel\Http\Resources\Json
     */
    public static function create(Request $request)
    {
        $data = $request->all();
        unset($data['api_token']);

        $ticket = TicketRepository::create($data);

        return new Json($ticket);
    }

    /**
     * Update a ticket.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id The discord id of the ticket.
     *
     * @return \Xetaravel\Http\Resources\Json
     */
    public function update(Request $request, int $id)
    {
        $ticket = Ticket::where('discord_id', $id)->first();

        $data = $request->all();
        unset($data['api_token']);

        $ticket = TicketRepository::update($data, $ticket);

        return new Json($ticket);
    }

    /**
     *  Get a user by his discord id.
     *
     * @param int $id The discord id of the user.
     *
     * @return \Xetaravel\Http\Resources\Json
     */
    public function getByTicketMessage(int $id)
    {
        $ticket = Ticket::where('ticket_message_id', $id)->first();

        return new Json($ticket);
    }
}

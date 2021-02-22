<?php
namespace Xetaravel\Models\Repositories;

use Illuminate\Support\Collection;
use Xetaravel\Models\Ticket;

class TicketRepository
{
    /**
     * Create the new ticket and save it.
     *
     * @param array $data The data used to create the ticket.
     *
     * @return \Xetaravel\Models\Ticket
     */
    public static function create(array $data) : Ticket
    {
        return Ticket::create([
            'discord_id' => $data['discord_id'],
            'ticket_count' => $data['ticket_count'],
            'ticket_opened' => $data['ticket_opened'],
            'ticket_message_id' => $data['ticket_message_id'],
            'last_ticket_date' => $data['last_ticket_date']
        ]);
    }

    /**
     * Update the account if it exist or create and save it.
     *
     * @param array $data The data used to update/create the account.
     * @param int $id The user id related to the account.
     *
     * @return \Xetaravel\Models\Ticket
     */
    public static function update(array $data, Ticket $ticket): Ticket
    {
        $ticket->ticket_count = $data['ticket_count'];
        $ticket->ticket_opened = $data['ticket_opened'];
        $ticket->ticket_message_id = $data['ticket_message_id'];
        $ticket->last_ticket_date = $data['last_ticket_date'];

        $ticket->save();

        return $ticket;
    }
}

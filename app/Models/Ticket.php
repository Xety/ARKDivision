<?php
namespace Xetaravel\Models;

class Ticket extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'discord_id',
        'ticket_count',
        'ticket_opened',
        'ticket_message_id',
        'last_ticket_date'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'last_ticket_date'
    ];
}

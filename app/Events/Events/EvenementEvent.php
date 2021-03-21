<?php
namespace Xetaravel\Events\Events;

use Xetaravel\Models\User;

class EvenementEvent
{
    /**
     * The user instance.
     *
     * @var \Xetaravel\Models\User
     */
    public $user;

    /**
     * Slug of the Evenement (slug) : `eventrockwell`, `eventsantiago`, `eventnakor`
     */
    public $slug;

    /**
     * Create a new event instance.
     *
     * @param \Xetaravel\Models\User $user
     * @param string $slug The slug of the Evenement
     */
    public function __construct(User $user, string $slug)
    {
        $this->user = $user;
        $this->slug = $slug;
    }
}

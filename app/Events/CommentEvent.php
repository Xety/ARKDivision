<?php
namespace Xetaravel\Events;

use Xetaravel\Models\User;

class CommentEvent
{
    /**
     * The user instance.
     *
     * @var \Xetaravel\Models\User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param \Xetaravel\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}

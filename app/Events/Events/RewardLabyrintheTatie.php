<?php
namespace Xetaravel\Events\Events;

use Xetaravel\Models\User;

class RewardLabyrintheTatie
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
     * @param \Xetaravel\Models\User $user The user that won the rewards.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}

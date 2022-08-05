<?php
namespace Xetaravel\Events\Donation;

use Xetaravel\Models\User;

class DonationRewardEvent
{
    /**
     * The user instance.
     *
     * @var \Xetaravel\Models\User
     */
    public $user;

    /**
     * The number of rewards.
     *
     * @var int
     */
    public $rewards;

    /**
     * Create a new event instance.
     *
     * @param \Xetaravel\Models\User $user The user that won the rewards.
     * @param int $rewards The number of rewards to attribute tot his user.
     */
    public function __construct(User $user, int $rewards)
    {
        $this->user = $user;
        $this->rewards = $rewards;
    }
}

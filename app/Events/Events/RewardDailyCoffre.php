<?php
namespace Xetaravel\Events\Events;

use Xetaravel\Models\Reward;
use Xetaravel\Models\User;

class RewardDailyCoffre
{
    /**
     * The user instance.
     *
     * @var \Xetaravel\Models\User
     */
    public $user;

    /**
     * The reward instance.
     *
     * @var \Xetaravel\Models\Reward
     */
    public $reward;

    /**
     * The bonus reward instance.
     *
     * @var \Xetaravel\Models\Reward|null
     */
    public $bonusReward;

    /**
     * Create a new event instance.
     *
     * @param \Xetaravel\Models\User $user The user that won the rewards.
     * @param \Xetaravel\Models\Reward $reward The reward the user has won.
     */
    public function __construct(User $user, Reward $reward, $bonusReward = null)
    {
        $this->user = $user;
        $this->reward = $reward;
        $this->bonusReward = $bonusReward;
    }
}

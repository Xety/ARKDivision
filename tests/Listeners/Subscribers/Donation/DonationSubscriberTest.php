<?php
namespace Tests\Listeners\Subscribers\Donation;

use Tests\TestCase;
use Xetaravel\Events\Donation\DonationRewardEvent;
use Xetaravel\Listeners\Subscribers\Donation\DonationSubscriber;
use Xetaravel\Models\User;

class DonationSubscriberTest extends TestCase
{
    /**
     * The listener used to make tests.
     *
     * @var \Xetaravel\Listeners\Subscribers\Donation\DonationSubscriber
     */
    protected $listener;

    /**
     * The user used in events.
     *
     * @var \Xetaravel\Models\User
     */
    protected $user;

    /**
     * Triggered before each test.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::find(1);
        $this->listener = new DonationSubscriber();
    }

    /**
     * testOnNewDonationWithOneReward method
     *
     * @return void
     */
    public function testOnNewDonationWithOneReward()
    {
        $this->listener->onNewDonation(new DonationRewardEvent($this->user, 1));

        $user = User::find(1)->with('Rewards')->first();
        $this->assertSame(3, $user->reward_count);
        $this->assertSame(3, $user->rewards()->count());
    }

    /**
     * testOnNewDonationWithMultipleReward method
     *
     * @return void
     */
    public function testOnNewDonationWithMultipleReward()
    {
        $this->listener->onNewDonation(new DonationRewardEvent($this->user, 3));

        $user = User::find(1)->with('Rewards')->first();
        $this->assertSame(9, $user->reward_count);
        $this->assertSame(9, $user->rewards()->count());
    }
}

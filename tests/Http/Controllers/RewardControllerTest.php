<?php
namespace Tests\Http\Controllers;

use Tests\TestCase;
use Xetaravel\Models\Reward;
use Xetaravel\Models\RewardUser;
use Xetaravel\Models\User;

class RewardControllerTest extends TestCase
{
    /**
     * Triggered before each test.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $user = User::find(1);
        $this->be($user);
    }

    /**
     * testIndexSuccess method
     *
     * @return void
     */
    public function testIndexSuccess()
    {
        $response = $this->get('/users/reward');
        $response->assertSuccessful();
    }

    /**
     * testMarkAsReadFail method
     *
     * @return void
     */
    public function testMarkAsReadFail()
    {
        $response = $this->json('POST', '/users/reward/markasread', ['id' => 123456789]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => true
            ]);
    }

    /**
     * testMarkAsRead method
     *
     * @return void
     */
    public function testMarkAsRead()
    {
        $user = User::find(1);
        $rewards = Reward::where('type', \Xetaravel\Events\Donation\DonationRewardEvent::class)->get();
        $user->rewards()->attach($rewards);

        $reward = RewardUser::find(1);
        $this->assertNull($reward->read_at);

        $response = $this->json('POST', '/users/reward/markasread', ['id' => 1]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false
            ]);

        $reward = RewardUser::find(1);
        $this->assertNotNull($reward->read_at);
    }

    /**
     * testClaimNoSteamId method
     *
     * @return void
     */
    public function testClaimNoSteamId()
    {
        $user = User::find(2);
        $this->be($user);

        $response = $this->json('POST', '/users/reward/claim', ['id' => 1]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => true
            ]);
    }

    /**
     * testClaimNoReward method
     *
     * @return void
     */
    public function testClaimNoReward()
    {
        $user = User::find(1);
        $this->be($user);

        $response = $this->json('POST', '/users/reward/claim', ['id' => 1]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => true
            ]);
    }

    /**
     * testClaimRewardAlreadyUsed method
     *
     * @return void
     */
    public function testClaimRewardAlreadyUsed()
    {
        $user = User::find(1);
        $rewards = Reward::where('type', \Xetaravel\Events\Donation\DonationRewardEvent::class)->get();
        $user->rewards()->attach($rewards);

        $user->rewards()->updateExistingPivot(1, [
            'was_used' => true
        ]);

        $response = $this->json('POST', '/users/reward/claim', ['id' => 1]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => true
            ]);
    }

    /**
     * testClaimRewardNotConnected method
     *
     * @return void
     */
    public function testClaimRewardNotConnected()
    {
        $user = User::find(1);
        $rewards = Reward::where('type', \Xetaravel\Events\Donation\DonationRewardEvent::class)->get();
        $user->rewards()->attach($rewards);

        $response = $this->json('POST', '/users/reward/claim', ['id' => 1]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => true
            ]);
    }
}

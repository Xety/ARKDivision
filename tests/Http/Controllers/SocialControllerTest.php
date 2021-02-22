<?php
namespace Tests\Http\Controllers;

use Xetaravel\Models\User;
use Tests\TestCase;

class SocialControllerTest extends TestCase
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
        $response = $this->get('/users/social');
        $response->assertSuccessful();
    }

    /**
     * testSteamSuccess method
     *
     * @return void
     */
    public function testSteamSuccess()
    {
        $response = $this->get('/users/social/steam');
        $response->assertStatus(302);
        $this->assertStringContainsString(
            'https://steamcommunity.com/openid/login',
            $response->headers->get('Location')
        );
    }

    /**
     * testSteamCallbackNoOpenId method
     *
     * @return void
     */
    public function testSteamCallbackNoOpenId()
    {
        $response = $this->get('/users/social/steamcallback/1?openid_claimed_id=');
        $response->assertSessionHas('danger');
        $response->assertStatus(302);
        $response->assertRedirect('/users/social');
    }

    /**
     * testSteamCallbackInvalidOpenId method
     *
     * @return void
     */
    public function testSteamCallbackInvalidOpenId()
    {
        $response = $this->get('/users/social/steamcallback/1?openid_claimed_id=123456789');
        $response->assertSessionHas('danger');
        $response->assertStatus(302);
        $response->assertRedirect('/users/social');
    }

    /**
     * testSteamCallbackInvalidOpenIdAfterSteamCheck method
     *
     * @return void
     */
    public function testSteamCallbackInvalidOpenIdAfterSteamCheck()
    {
        $response = $this->get('/users/social/steamcallback/1?openid_claimed_id=12345678912345678');
        $response->assertSessionHas('danger');
        $response->assertStatus(302);
        $response->assertRedirect('/users/social');
    }

    /**
     * testSteamCallbackSuccess method
     *
     * @return void
     */
    public function testSteamCallbackSuccess()
    {
        $response = $this->get('/users/social/steamcallback/1?openid_claimed_id=76561198099250608');
        $response->assertSessionHas('success');
        $response->assertStatus(302);
        $response->assertRedirect('/users/social');
    }

    /**
     * testDeleteSocialInvalidType method
     *
     * @return void
     */
    public function testDeleteSocialInvalidType()
    {
        $response = $this->delete('/users/social/delete/test');
        $response->assertSessionHas('danger');
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    /**
     * testDeleteSocialDiscord method
     *
     * @return void
     */
    public function testDeleteSocialDiscord()
    {
        $user = User::find(1)->with('Account')->first();
        $this->assertNotNull($user->account->discord_username);
        $this->assertNotNull($user->account->discord_discriminator);

        $response = $this->delete('/users/social/delete/discord');
        $response->assertSessionHas('success');
        $response->assertStatus(302);
        $response->assertRedirect('/');

        $user = User::find(1)->with('Account')->first();
        $this->assertNull($user->account->discord_username);
        $this->assertNull($user->account->discord_discriminator);
    }

    /**
     * testDeleteSocialDiscord method
     *
     * @return void
     */
    public function testDeleteSocialSteam()
    {
        $user = User::find(1)->with('Account')->first();
        $this->assertNotNull($user->account->steam_username);

        $response = $this->delete('/users/social/delete/steam');
        $response->assertSessionHas('success');
        $response->assertStatus(302);
        $response->assertRedirect('/');

        $user = User::find(1)->with('Account')->first();
        $this->assertNull($user->account->steam_username);
    }
}

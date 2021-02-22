<?php
namespace Tests\Http\Controllers\Donation;

use Xetaravel\Models\User;
use Tests\TestCase;

class PageControllerTest extends TestCase
{
    /**
     * testIndexNotLoggedInSuccess method
     *
     * @return void
     */
    public function testIndexNotLoggedInSuccess()
    {
        $response = $this->get(route('donation.page.index'));
        $response->assertSuccessful();
        $response->assertSee('alert alert-danger');
    }

    /**
     * testIndexNotLoggedInSuccess method
     *
     * @return void
     */
    public function testIndexLoggedInSuccess()
    {
        $user = User::find(1)->with('Account')->first();
        $this->be($user);

        $response = $this->get(route('donation.page.index'));
        $response->assertSuccessful();
        $response->assertSee('alert alert-success');
        $response->assertSee($user->account->discord_username . '#' . $user->account->discord_discriminator);
    }
}

<?php
namespace Tests\Http\Controllers\Auth;

use Tests\TestCase;

class SocialiteControllerTest extends TestCase
{
    /**
     * testShowRegistrationFormWithoutDriver method
     *
     * @return void
     */
    public function testShowRegistrationFormWithoutDriver()
    {
        $response = $this->get('/auth/discord/register/form');
        $response->assertStatus(302);
        $response->assertRedirect('/users/login');
    }

    /**
     * testShowRegistrationFormSuccess method
     *
     * @return void
     */
    public function testShowRegistrationFormSuccess()
    {

        $response = $this->withSession(['socialite.driver' => 'discord'])->get('/auth/discord/register/form');
        $response->assertSuccessful();
    }

    /**
     * testRedirectToProvider method
     *
     * @return void
     */
    public function testRedirectToProvider()
    {
        $response = $this->get('/auth/discord/redirect');
        $response->assertStatus(302);
        $redirect = urlencode(route('auth.driver.callback', ['driver' => 'discord']));

        $this->assertStringContainsString(
            'https://discord.com/api/oauth2/authorize?redirect_uri=' . $redirect,
            $response->headers->get('Location')
        );
    }

    /**
     * testRegisterValidationFail method
     *
     * @return void
     */
    public function testRegisterValidationFail()
    {
        $data = ['username' => 'admin', 'email' => 'admin@xeta.io'];
        $response = $this->post('/auth/discord/register/validate', $data);
        $response->assertStatus(302);
    }
}

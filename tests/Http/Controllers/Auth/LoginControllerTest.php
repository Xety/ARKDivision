<?php
namespace Tests\Http\Controllers\Auth;

use Xetaravel\Models\User;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    /**
     * testShowLoginForm method
     *
     * @return void
     */
    public function testShowLoginForm()
    {
        $response = $this->get('/users/login');
        $response->assertSuccessful();
    }

    /**
     * testLoginSuccess method
     *
     * @return void
     */
    public function testLoginSuccess()
    {
        $this->assertGuest();
        $data = [
            'email' => 'admin@division.io',
            'password' => 'admin',
            'remember' => 1,
        ];
        $response = $this->post('/users/login', $data);
        $this->assertAuthenticated();
        $response->assertSessionHas('success');
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    /**
     * testLoginFailed method
     *
     * @return void
     */
    public function testLoginNotValidated()
    {
        $this->assertGuest();
        $data = [
            'email' => 'membre@division.io',
            'password' => 'membre',
            'remember' => 1,
        ];
        $response = $this->post('/users/login', $data);

        $this->assertGuest();
        $response->assertStatus(302);
        $this->assertStringContainsString(
            '/users/email/verify',
            $response->headers->get('Location')
        );
    }

    /**
     * testLoginFailed method
     *
     * @return void
     */
    public function testLoginFailed()
    {
        $this->assertGuest();
        $data = [
            'email' => 'admin@division.io',
            'password' => 'wrong-password',
            'remember' => 1,
        ];
        $response = $this->post('/users/login', $data);

        $this->assertGuest();
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    /**
     * testLogoutSuccess method
     *
     * @return void
     */
    public function testLogoutSuccess()
    {
        $this->be(User::find(1));
        $this->assertAuthenticated();

        $response = $this->post('/users/logout');

        $this->assertGuest();
        $response->assertSessionHas('success');
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
}

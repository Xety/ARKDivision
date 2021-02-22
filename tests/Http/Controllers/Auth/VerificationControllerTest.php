<?php
namespace Tests\Http\Controllers\Auth;

use Tests\TestCase;

class VerificationControllerTest extends TestCase
{
    /**
     * testShowSuccess method
     *
     * @return void
     */
    public function testShowSuccess()
    {
        $response = $this->get('/users/email/verify/' . base64_encode(3));
        $response->assertSuccessful();
    }

    /**
     * testResendSuccess method
     *
     * @return void
     */
    public function testResendSuccess()
    {
        $response = $this->post('/users/email/resend', ['hash' => base64_encode(3)]);
        $response->assertSessionHas('resent');
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    /**
     * testResendAlreadyVerified method
     *
     * @return void
     */
    public function testResendAlreadyVerified()
    {
        $response = $this->post('/users/email/resend', ['hash' => base64_encode(1)]);
        $response->assertStatus(302);
        $response->assertRedirect('/users/login');
    }
}

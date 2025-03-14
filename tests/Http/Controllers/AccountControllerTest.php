<?php
namespace Tests\Http\Controllers;

use Xetaravel\Models\User;
use Tests\TestCase;

class AccountControllerTest extends TestCase
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
        $response = $this->get('/users/account');
        $response->assertSuccessful();
    }

    /**
     * testUpdateSuccess method
     *
     * @return void
     */
    public function testUpdateSuccess()
    {
        $user = User::find(1);

        $this->assertSame('Emeric', $user->first_name);
        $this->assertSame('', $user->last_name);

        $oldAvatarUrl = $user->avatar_small;

        $file = new \Illuminate\Http\UploadedFile(
            base_path('tests/storage/tmp_avatar.png'),
            'tmp_avatar.png',
            'image/png',
            null,
            true
        );

        $data = [
            'first_name' => 'Jhon',
            'last_name' => 'Doe',
            'avatar' => $file
        ];
        $response = $this->put('/users/account', $data);
        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $user = User::find(1);
        $this->assertNotSame($oldAvatarUrl, $user->avatar_small, 'The path should not be the same.');
        $this->assertSame('Jhon', $user->first_name);
        $this->assertSame('Doe', $user->last_name);
    }
}

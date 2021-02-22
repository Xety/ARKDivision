<?php
namespace Tests\Http\Controllers\Discuss;

use Tests\TestCase;
use Xetaravel\Models\DiscussPost;
use Xetaravel\Models\User;

class PostControllerTest extends TestCase
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
     * testCreateSuccess method
     *
     * @return void
     */
    public function testCreateSuccess()
    {
        $data = [
            'conversation_id' => 1,
            'content' => '**This** is an awesome text.'
        ];

        $response = $this->post('/post/create', $data);
        $response->assertSessionHas('success');
        $response->assertStatus(302);
    }

    /**
     * testShowSuccess method
     *
     * @return void
     */
    public function testShowSuccess()
    {
        $response = $this->get('/post/show/2');
        $response->assertStatus(302);
        $response->assertRedirect('/conversation/this-is-an-announcement.1?page=1&#post-2');
    }

    /**
     * testDeleteSuccess method
     *
     * @return void
     */
    public function testDeleteSuccess()
    {
        $response = $this->delete('/post/delete/2');
        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $this->assertNull(DiscussPost::find(2));
    }

    /**
     * testDeleteFirstPostFailed method
     *
     * @return void
     */
    public function testDeleteFirstPostFailed()
    {
        $response = $this->delete('/post/delete/1');
        $response->assertStatus(302);
        $response->assertSessionHas('danger');
    }

    /**
     * testSolvedSuccess method
     *
     * @return void
     */
    public function testSolvedSuccess()
    {
        $response = $this->get('/post/solved/2');
        $response->assertStatus(302);
        $response->assertSessionHas('success');
    }

    /**
     * testAlreadySolvedFailed method
     *
     * @return void
     */
    public function testAlreadySolvedFailed()
    {
        $response = $this->get('/post/solved/2');

        $response = $this->get('/post/solved/2');
        $response->assertStatus(302);
        $response->assertSessionHas('danger');
    }

    /**
     * testSolvedPermissionFailed method
     *
     * @return void
     */
    public function testSolvedPermissionFailed()
    {
        $user = User::find(3);
        $this->be($user);

        $response = $this->get('/post/solved/2');
        $response->assertStatus(403);
    }

    /**
     * testEditSuccess method
     *
     * @return void
     */
    public function testEditSuccess()
    {
        $data = [
            'content' => 'This is an edited post.'
        ];

        $response = $this->put('/post/edit/1', $data);
        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $post = DiscussPost::findOrFail(1);

        $this->assertSame($data['content'], $post->content);
    }

    /**
     * testEditNotAuthorizedFailed method
     *
     * @return void
     */
    public function testEditNotAuthorizedFailed()
    {
        $user = User::find(3);
        $this->be($user);

        $data = [
            'content' => 'This is an edited post.'
        ];

        $response = $this->put('/post/edit/1', $data);
        $response->assertStatus(302);
        $response->assertSessionHas('danger');
    }
}

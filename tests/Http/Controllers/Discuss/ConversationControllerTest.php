<?php
namespace Tests\Http\Controllers\Discuss;

use Tests\TestCase;
use Xetaravel\Models\DiscussConversation;
use Xetaravel\Models\DiscussLog;
use Xetaravel\Models\DiscussPost;
use Xetaravel\Models\User;

class ConversationControllerTest extends TestCase
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
     * testShow method
     *
     * @return void
     */
    public function testShow()
    {
        $response = $this->get(route('discuss.conversation.show', ['slug' => 'this-is-an-announcement', 'id' => 1]));
        $response->assertSuccessful();
    }

    /**
     * testShowCreateForm method
     *
     * @return void
     */
    public function testShowCreateForm()
    {
        $response = $this->get(route('discuss.conversation.showcreate'));
        $response->assertSuccessful();
    }

    /**
     * testCreateIsFloodingFailed method
     *
     * @return void
     */
    public function testCreateIsFloodingFailed()
    {
        $user = User::find(3);
        $this->be($user);

        config(['xetaravel.flood.discuss.conversation' => (60 * 10)]);

        $data = [
            'title' => 'This is a test',
            'category_id' => 2,
            'content' => '**This** is an awesome text.'
        ];
        $this->post(route('discuss.conversation.create'), $data);

        $response = $this->post(route('discuss.conversation.create'), $data);
        $response->assertSessionHas('danger');
        $response->assertStatus(302);
    }

    /**
     * testCreateSuccess method
     *
     * @return void
     */
    public function testCreateSuccess()
    {
        $user = User::find(2);
        $this->be($user);

        $data = [
            'title' => 'This is a test 2',
            'category_id' => 2,
            'content' => '**This** is an awesome text.'
        ];

        $response = $this->post(route('discuss.conversation.create'), $data);
        $response->assertSessionHas('success');
        $response->assertStatus(302);
    }

    /**
     * testUpdateSuccess method
     *
     * @return void
     */
    public function testUpdateSuccess()
    {
        $data = [
            'title' => 'This is an announcement',
            'category_id' => 1,
            'is_locked' => false
        ];
        $response = $this->put(
            route('discuss.conversation.update', ['id' => 1, 'slug' => 'this-is-an-announcement']),
            $data
        );
        $response->assertSessionHas('success');
        $response->assertStatus(302);

        $conversation = DiscussConversation::findOrFail(1);

        $this->assertSame(0, $conversation->is_locked);

        $data = [
            'title' => 'This is a test',
            'category_id' => 2,
            'is_locked' => true,
            'is_pinned' => true
        ];

        $response = $this->put(
            route('discuss.conversation.update', ['id' => 1, 'slug' => 'this-is-an-announcement']),
            $data
        );
        $response->assertSessionHas('success');
        $response->assertStatus(302);

        $conversation = DiscussConversation::findOrFail(1);

        $this->assertSame(2, $conversation->edit_count);
        $this->assertSame(1, $conversation->edited_user_id);
        $this->assertSame(2, $conversation->category_id);
        $this->assertSame('This is a test', $conversation->title);
        $this->assertSame('this-is-a-test', (string)$conversation->slug);
        $this->assertSame(1, $conversation->is_locked);
        $this->assertSame(1, $conversation->is_pinned);
    }

    /**
     * testDeleteSuccess method
     *
     * @return void
     */
    public function testDeleteSuccess()
    {
        $response = $this->delete(route('discuss.conversation.delete', [
            'id' => 1, 'slug' => 'this-is-an-announcement'
        ]));
        $response->assertSessionHas('success');
        $response->assertStatus(302);

        $conversation = DiscussConversation::find(1);
        $posts = DiscussPost::where('conversation_id', 1)->get();
        $logs = DiscussLog::where([
            'loggable_type' => DiscussConversation::class,
            'loggable_id' => 1,
        ])->get();
        $user = User::findOrFail(1);

        $this->assertNull($conversation);
        $this->assertTrue($posts->isEmpty());
        $this->assertTrue($logs->isEmpty());
        $this->assertSame(0, $user->discuss_post_count);
        $this->assertSame(0, $user->discuss_conversation_count);
    }
}

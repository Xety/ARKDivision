<?php
namespace Xetaravel\Policies;

use Xetaravel\Models\User;
use Xetaravel\Models\DiscussPost;
use Xetaravel\Models\DiscussConversation;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiscussPostPolicy
{
    use HandlesAuthorization;

    /**
     * Authorize all actions if the user has the given permission.
     *
     * @param \Xetaravel\Models\User $user
     * @param string $ability
     *
     * @return true|void
     */
    public function before(User $user, string $ability)
    {
        if ($user->hasPermission('manage.discuss.posts')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the discuss post.
     *
     * @param \Xetaravel\Models\User $user
     * @param \Xetaravel\Models\DiscussPost $discussPost
     *
     * @return bool
     */
    public function update(User $user, DiscussPost $discussPost)
    {
        return $user->id === $discussPost->user_id;
    }

    /**
     * Determine whether the user can delete the discuss post.
     *
     * @param \Xetaravel\Models\User $user
     * @param \Xetaravel\Models\DiscussPost $discussPost
     *
     * @return bool
     */
    public function delete(User $user, DiscussPost $discussPost)
    {
        return $user->id === $discussPost->user_id;
    }

    /**
     * Determine whether the user can make a discuss post as solved.
     * User must be the creator of the conversation to be able to make a
     * post as solved.
     *
     * @param \Xetaravel\Models\User $user
     * @param \Xetaravel\Models\DiscussConversation $discussConversation
     *
     * @return bool
     */
    public function solved(User $user, DiscussConversation $discussConversation)
    {
        return $user->id === $discussConversation->user_id;
    }
}

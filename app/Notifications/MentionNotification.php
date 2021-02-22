<?php
namespace Xetaravel\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Xetaravel\Models\DiscussPost;

class MentionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The model instance.
     *
     * @var \Xetaravel\Models\Model
     */
    public $model;

    /**
     * Create a new notification instance.
     *
     * @param \Xetaravel\Models\Model $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toDatabase($notifiable): array
    {
        return $this->parseInstance(['type' => 'mention']);
    }

    /**
     * Parse the instance of the model and build the array.
     *
     * @param array $data
     *
     * @return array
     */
    protected function parseInstance(array $data = [])
    {
        $model = $this->model;

        switch (true) {
            case $model instanceof DiscussPost:
                $data['message'] = '<strong>@%s</strong> a mentionné votre nom dans son message!';
                $data['link'] = $model->post_url;

                break;

            default:
                $data['message'] = 'Mention inconnue.';
                $data['link'] = route('users.notification.index');

                break;
        }
        $data['message'] = sprintf($data['message'], $model->user->username);

        return $data;
    }
}

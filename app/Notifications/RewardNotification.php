<?php
namespace Xetaravel\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class RewardNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The reward instance.
     *
     * @var \Xetaravel\Models\Reward
     */
    public $reward;

    /**
     * Create a new notification instance.
     *
     * @param \Xetaravel\Models\Reward $reward
     */
    public function __construct($reward)
    {
        $this->reward = $reward;
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
        return [
            'message' => 'Vous avez déverrouillé la récompense <strong>%s</strong> !',
            'message_key' => [$this->reward->name],
            'image' => $this->reward->image,
            'type' => 'reward'
        ];
    }
}

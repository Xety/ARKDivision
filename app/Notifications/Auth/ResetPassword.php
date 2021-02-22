<?php
namespace Xetaravel\Notifications\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param string $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('Vous recevez cet e-mail car nous avons reçu une demande de réinitialisation ' .
                        'de mot de passe pour votre compte.')
            ->line('Si vous n\'avez pas demandé de réinitialisation de mot de passe, aucune autre ' .
                        'action n\'est requise et vous pouvez ignorer cet e-mail.')
            ->action(
                'Réinitialiser mon Mot de Passe',
                url(config('app.url') . route('users.auth.password.reset', $this->token, false))
            )
            ->level('primary')
            ->subject('Réinitialisation de Mot de Passe - ' . config('app.name'))
            ->from(config('xetaravel.site.contact_email'), config('app.name'));
    }
}

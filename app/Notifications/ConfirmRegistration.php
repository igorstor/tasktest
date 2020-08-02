<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Class ConfirmRegistration
 * @package App\Notifications
 */
class ConfirmRegistration extends Notification implements ShouldQueue
{
    use Queueable;
    /**
     * @var
     */
    private $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        $url = route('api.users.confirm.register', $this->token);
        return (new MailMessage)
            ->subject('Confirm registration')
            ->line('Thanks for signup! Please before you begin, you must confirm your account.')
            ->action('Confirm Account', url($url));
    }

}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PasswordResetRequest extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = env('APP_HOST_NAME') . '/password/change/' . $this->token;
        return (new MailMessage)
            ->subject('Сброс пароля nady.shop')
            ->greeting('Здравствуйте!')
            ->line('Вы получили это письмо, потому что решили поменять пароль своей учетной записи. Чтобы сбросить пароль нажмите на кнопку ниже:')
            ->action('Сбросить пароль', url($url))
            ->line('Не предпринимайте никаких действий, если это не вы запросили смену пароля')
            ->salutation('С уважением, nady.shop');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

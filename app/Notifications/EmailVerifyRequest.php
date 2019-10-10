<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EmailVerifyRequest extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $username;
    public $token;

    public function __construct($username, $token)
    {
        $this->username = $username;
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
//        username={{ $user->email }}&token={{ $user->verification_token }}
        $url = env('APP_HOST_NAME') . '/api/v1/confirm?username=' . $this->username . '&token=' . $this->token;
        return (new MailMessage)
                    ->subject('Подтверждение аккаунта nady.shop')
                    ->greeting('Здравствуйте!')
                    ->line('Вы получили это письмо, потому что зарегистрировались на сайте nadya.shop. Чтобы подтвердить свой аккаунт  перейдите по ссылке: ')
                    ->action('Подтвердить профиль', url($url))
                    ->line('Не предпринимайте никаких действий, если вы не регистрировались')
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

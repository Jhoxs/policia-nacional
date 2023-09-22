<?php

namespace App\Notifications\Maintenance;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GenericOrder extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($user, $msj)
    {
        $this->user     = $user;
        $this->msj       = $msj;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Solicitudes')
                    ->greeting('Saludos, '.$this->user->name)
                    ->line(''.$this->msj)
                    ->line('Para más información puedes ingresar a la aplicación.')
                    ->action('Ingresar', url(env('APP_URL')));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

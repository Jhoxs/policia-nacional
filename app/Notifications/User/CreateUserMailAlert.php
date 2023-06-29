<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreateUserMailAlert extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
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
                    ->subject('Bienvenido/a a la aplicación')
                    ->greeting('Hola, '.$this->user->name)
                    ->line('Te damos la bienvenida a la aplicación de gestion vehicular de la Policía nacional.')
                    ->line('Correo Electónico: '.$this->user->email)
                    ->line('Contraseña temporal: '.$this->user->password)
                    ->line('Recuerda cambiar tu contraseña al ingresar a la aplicación.')
                    ->action('Ingresar', url(env('APP_URL')))
                    ->line('¡Gracias por ser parte de nuestra comunidad!');
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

<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestVehicleMailAlert extends Notification
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
                    ->subject('Solicitud Asignación Vehículo')
                    ->greeting('Saludos,')
                    ->line('Te informamos que el usuario '.$this->user->email.' ha solicitado una asignación de vehículo.')
                    ->line('Nombre: '.$this->user->full_name)
                    ->line('Identificación: '.$this->user->identification)
                    ->line('Para poder asignar el vehículo a un usuario ingresa a nuestro sistema.')
                    ->action('Ingresar', url(env('APP_URL').'/uservehicle'));
                    //->line('¡Gracias por ser parte de nuestra comunidad!');
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

<?php

namespace App\Notifications\Maintenance;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RemindMaintenanceMailAlert extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($user, $vehicle)
    {
        $this->user     = $user;
        $this->vehicle  = $vehicle;
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
                    ->subject('Recordatorio de mantenimiento')
                    ->greeting('Saludos, '.$this->user->name)
                    ->line('Te recordamos que se debe hacer el mantenimiento pertinente al vehículo que tienes asignado.')
                    ->line('Placa: '.$this->vehicle->plate)
                    ->line('Kilometraje Actual: '.$this->vehicle->mileage)
                    ->line('Próximo Kilometraje: '.$this->vehicle->next_mileage)
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

<?php

namespace App\Notifications\Maintenance;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Barryvdh\DomPDF\Facade\Pdf;

class AcceptMaintenanceNotify extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($maintenanceInfo)
    {
        $this->maintenanceInfo = $maintenanceInfo;
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
        $infoMaintenance = $this->maintenanceInfo;
        
        $info = [
            'mileage' => $infoMaintenance->vehicle->mileage ?? '',
            'plate' => $infoMaintenance->vehicle->plate ?? '',
            'name'    => $infoMaintenance->user->full_name ?? '',
            'shift_time_range'    => $infoMaintenance->shift_time_range ?? '',
            'shift_date'    => $infoMaintenance->shift_date ?? '',
            'description'    => $infoMaintenance->description ?? '',
        ];
        
        return (new MailMessage)
            ->subject('Estado de Solicitud Mantenimiento Vehículo')
            ->greeting('Saludos '.$info['name'].',')
            ->line('Te informamos que la solicitud de mantenimiento ha sido ACEPTADA, Por lo que es necesario acercarse a las instalaciones de mecánica de la policía con el vehículo responsable')
            ->line('Información del Turno')
            ->line('Placa del vehículo: '.$info['plate'])
            ->line('Kilometraje: '.$info['mileage'])
            ->line('Fecha del Turno: '.$info['shift_date'])
            ->line('Horario del Turno: '.$info['shift_time_range'])
            ->line('Observaciones: '.$info['description'])
            ->line('Recuerda acercarte en el dia y el horario registrados.')
            ->line('Para más información ingresa a nuestro sitio web')
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

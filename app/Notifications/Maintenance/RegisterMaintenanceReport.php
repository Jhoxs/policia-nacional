<?php

namespace App\Notifications\Maintenance;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Barryvdh\DomPDF\Facade\Pdf;

class RegisterMaintenanceReport extends Notification
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
        $pdf = Pdf::loadView('PDF.register-maintenance', compact('infoMaintenance'));
        $details = $infoMaintenance->maintenance['details'] ?? '';
        return (new MailMessage)
            ->subject('Solicitud Mantenimiento Vehículo')
            ->greeting('Saludos,')
            ->line('Te informamos que el usuario '.$infoMaintenance->user->email.' ha solicitado dar mantenimiento al vehículo que tiene asignado.')
            ->line('Información del Turno')
            ->line('Kilometraje: '.$infoMaintenance->maintenance['mileage'])
            ->line('Fecha del Turno: '.$infoMaintenance->maintenance['shift_date'])
            ->line('Horario del Turno: '.$infoMaintenance->maintenance['shift_range'])
            ->line('Observaciones: '.$details)
            ->line('Para poder revisar la solicitud ingresa al sistema web.')
            ->action('Ingresar', url(env('APP_URL').'/uservehicle'))
            ->attachData($pdf->output(),'solicitud_mantenimiento_'.$infoMaintenance->user->email.'.pdf');
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

<?php

namespace App\Helpers;

class MaintenanceHelper
{
    public static function statusMaintenaceDictionary($status)
    {
        $dictionary = [
            0 => 'SOLICITUD ENVIADA',
            1 => 'SOLICITUD RECHAZADA',
            2 => 'EN MANTENIMIENTO',
            3 => 'EN ENTREGA',
            4 => 'FINALIZADO'
        ];

        return $dictionary[$status];
    }
}
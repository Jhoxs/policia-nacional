<?php

namespace App\Helpers;

class StatusHelper
{
    public static function statusCodeDictionary($status)
    {
        $dictionary = [
            '404' => [
                'status'    => '404',    
                'title'     => '404',
                'subTitle'  => 'Lo sentimos, la página que buscas no existe.'

            ],
            '403' => [
                'status'    => '403',    
                'title'     => '403',
                'subTitle'  => 'Tú no estas autorizado para acceder a esta página.'

            ],
            '405' => [
                'status'    => '405',    
                'title'     => '405',
                'subTitle'  => 'Lo sentimos, ha ocurrido un error inesperado.'

            ],
        ];

        return $dictionary[$status] ?? reset($dictionary);
    }
}
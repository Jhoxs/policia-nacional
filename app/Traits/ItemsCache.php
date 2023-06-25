<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait ItemsCache{

    protected $modelName;
    
    /**
     * Eliminamos el cache
     */
    protected function removeMenuFromCache()
    {
        Cache::forget('pn_admin_'.$this->modelName);
    }

    /**
     * Mostramos la opciones en un arreglo de objetos {value:'',label:''}.
     * @return object
     */
    public function displayFormattedOptions($time_life_days = 30)
    {   
        $data_formatted = Cache::remember('pn_admin_'.$this->modelName, \Carbon\Carbon::now()->addDays($time_life_days), function () {
            return static::select('id as value','display_name as label')->get();
        });

        if (!isset($data_formatted) || $data_formatted->isEmpty()) {
            return false;
        }

        return $data_formatted;

    }
}
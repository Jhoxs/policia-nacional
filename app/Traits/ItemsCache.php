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
     * Eliminamos el cache con el nombre del modelo
     */
    protected function removeMenuFromCacheByModelName($customModelName)
    {
        Cache::forget('pn_admin_'.$customModelName);
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
            return static::select('id as value','display_name as label')->get();
        }

        return $data_formatted;

    }
}
<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Helpers\MaintenanceHelper;


class MaintenanceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) 
    {
        return $this->collection->map(function($item){

            return [
                'key'               => $item->id,
                'chassis'           => $item->vehicle->chassis,
                'mileage'           => $item->vehicle->mileage,
                'status'            => MaintenanceHelper::statusMaintenaceDictionary($item->status),
                'in_progress'       => $item->in_progress,
                'shift_time_range'  => $item->shift_time_range,
                'description'       => $item->description,
                'shift_date'        => $item->shift_date,
                'plate'             => $item->vehicle->plate,
                'plate'             => $item->vehicle->plate,
                'reason_reject'     => $item->reason_reject,
                'identification'    => $item->user->identification
            ];
        });

    }
}

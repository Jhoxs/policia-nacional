<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Helpers\MaintenanceHelper;
use App\Models\Vehicle;
use App\Models\User;

class MorderCollection extends ResourceCollection
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

            $driver = User::find($item->driver_id);
            $resp = User::find($item->user_id);
            $vehicle = Vehicle::find($item->vehicle_id);
            

            return [
                'key'               => $item->id,
                'plate'             => $vehicle->plate,
                'chassis'           => $vehicle->chassis,
                'driver'            => $driver,
                'responsable'       => $resp,
                'status'            => MaintenanceHelper::statusOrderDictionary($item->status),
                'in_progress'       => $item->in_progress,
                'departure_date'    => $item->departure_date,
                'departure_time'    => $item->departure_time,
                'reason'            => $item->reason,
                'rute'              => $item->rute,
                'vehicle'           => $vehicle,
                'mileage'           => $item->current_mileage,
                'identification'    => $resp->identification,
                'identification_driver' => $driver->identification,
                'identification_pass'   => $item->passengers
            ];
        });

    }
}

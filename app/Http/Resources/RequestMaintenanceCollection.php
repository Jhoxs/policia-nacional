<?php
 
namespace App\Http\Resources;
 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;
 
class RequestMaintenanceCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->collection->map(function($item){
            //$subcircuits = $item->user->subcircuits->pluck(['display_name']);
            
            return [
                'key'               => $item->id,
                'shift_date'        => $item->shift_date,
                'shift_time'        => $item->shift_time_range,
                'details'           => $item->details ?? 'Ninguno',
                'u_name'            => $item->user->name,
                'u_last_name'       => $item->user->last_name,
                'u_full_name'       => $item->user->full_name,
                'u_identification'  => $item->user->identification,
                'u_email'           => $item->user->email,
                'v_plate'           => $item->vehicle->plate, 
                'v_chassis'         => $item->vehicle->chassis, 
                //'subcircuits'       => $subcircuits,
                'created_at'        => date('Y-m-d',strtotime($item->created_at)),
                
            ];
        });
    }
}
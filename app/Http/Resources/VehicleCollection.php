<?php
 
namespace App\Http\Resources;
 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;
 
class VehicleCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->collection->map(function($item){
            
            return [
                'key' => $item->id,
                'plate' => $item->plate,
                'chassis' => $item->chassis,
                'brand'=>$item->brand,
                'model' => $item->model,
                'motor'=>$item->motor,
                'mileage' => $item->mileage,
                'next_mileage' => $item->next_mileage,
                'cylinder_capacity'  => $item->cylinder_capacity,
                'loading_capacity' => $item->loading_capacity,
                'passenger_capacity' => $item->passenger_capacity,
                'vehicle_type' => $item->vehicle_type->display_name
            ];
        });
    }
}
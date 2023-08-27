<?php
 
namespace App\Http\Resources;
 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
 
class VehicleResourcePreview extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'key'                   => $this->id ?? '',
            'plate'                 => $this->plate ?? '',
            'chassis'               => $this->chassis ?? '',
            'brand'                 => $this->brand ?? '',
            'model'                 => $this->model ?? '',
            'motor'                 => $this->motor ?? '',
            'mileage'               => $this->mileage ?? '',
            'next_mileage'          => $this->next_mileage ?? '',
            'cylinder_capacity'     => $this->cylinder_capacity ?? '',
            'loading_capacity'      => $this->loading_capacity ?? '',
            'passenger_capacity'    => $this->passenger_capacity ?? '', 
            'vehicle_type'          => $this->vehicle_type->display_name ?? '', 
            //'vehicle_type_name' => $this->vehicle_type->display_name
        ];
        
    }
}
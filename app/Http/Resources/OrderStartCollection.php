<?php
 
namespace App\Http\Resources;
 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;
 
class OrderStartCollection extends ResourceCollection
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
                'key'                       => $item->id,
                'vehicle_id'                => $item->vehicle_id, 
                'user_id'                   => $item->user_id, 
                'img_vehicle'               => asset('/storage/'.$item->img_vehicle), 
                'signature_responsibility'  => asset('/storage/'.$item->signature_responsibility), 
                'detail'                    => $item->detail,
                'admission_date'            => $item->admission_date,
                'current_mileage'           => $item->current_mileage,
            ];
        });
    }
}
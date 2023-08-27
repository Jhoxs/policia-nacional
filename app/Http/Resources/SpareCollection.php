<?php
 
namespace App\Http\Resources;
 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;
 
class SpareCollection extends ResourceCollection
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
                'key'       => $item->id,
                'name'      => $item->name,
                'brand'     => $item->brand,
                'price'     => $item->price,
                'detail'    => $item->detail,
            ];
        });
    }
}
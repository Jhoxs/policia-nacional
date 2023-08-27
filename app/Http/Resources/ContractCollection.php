<?php
 
namespace App\Http\Resources;
 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;
 
class ContractCollection extends ResourceCollection
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
                'key'           => $item->id,
                'name'          => $item->name,
                'price'         => $item->price,
                'detail'        => $item->detail,
                'spares'        => $item->spares ?? [],
            ];
        });
    }
}
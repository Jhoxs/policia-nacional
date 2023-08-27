<?php
 
namespace App\Http\Resources;
 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
 
class SpareResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {

        return [
            'key'       => $this->id,
            'name'      => $this->name,
            'brand'     => $this->brand,
            'price'     => $this->price,
            'detail'    => $this->detail,
        ];
    
    }
}
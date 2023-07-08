<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CityCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->collection->map(function($item){
            return [
                'key' => $item->id,
                'code' => $item->code,
                'display_name' => $item->display_name,
                'province' => $item->province->display_name,
            ];
        });
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CircuitCollection extends ResourceCollection
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
                'code_circ' => $item->code,
                'display_name_circ' => $item->display_name,
                'code_parish' => $item->parish->code,
                'parish' => $item->parish->display_name,
                'city' => $item->parish->city->display_name,
                'province' => $item->parish->city->province->display_name,
            ];
        });
    }
}

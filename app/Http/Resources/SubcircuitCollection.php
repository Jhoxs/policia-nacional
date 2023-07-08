<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SubcircuitCollection extends ResourceCollection
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
                'code_subc' => $item->code,
                'display_name_subc' => $item->display_name,
                'code_circ' => $item->circuit->code,
                'display_name_circ' => $item->circuit->display_name,
                'code_parish' => $item->circuit->parish->code,
                'parish' => $item->circuit->parish->display_name,
                'city' => $item->circuit->parish->city->display_name,
                'province' => $item->circuit->parish->city->province->display_name,
            ];
        });
    }
}

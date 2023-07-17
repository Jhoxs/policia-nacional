<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SuggCreateCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->collection->map(function ($circuit) {
            return [
                'value' => $circuit->id,
                'label' => $circuit->display_name,
                'children' => $circuit->subcircuits->map(function ($subcircuits) {
                    return [
                        'value' => $subcircuits->id,
                        'label' => $subcircuits->display_name,
                    ];
                }),
            ];
        });
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProvinceCircuitCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->collection->map(function ($province) {
            return [
                'value' => $province->id,
                'label' => $province->display_name,
                'children' => $province->cities->map(function ($city) {
                    return [
                        'value' => $city->id,
                        'label' => $city->display_name,
                        'children' => $city->parishes->map(function ($parish) {
                            return [
                                'value' => $parish->id,
                                'label' => $parish->display_name,
                            ];
                        }),
                    ];
                }),
            ];
        });
    }
}

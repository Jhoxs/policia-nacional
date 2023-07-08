<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'key' => $this->id,
            'code' => $this->code,
            'display_name' => $this->display_name,
            'name' => $this->name,
            'dependences' => [
                $this->province->id,
            ]
        ];
    }
}

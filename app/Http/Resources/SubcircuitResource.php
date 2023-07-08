<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubcircuitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'key' => $this->id,
            'code' => $this->code,
            'display_name' => $this->display_name,
            'name' => $this->name,
            'dependences' => [
                $this->circuit->parish->city->province->id,
                $this->circuit->parish->city->id,
                $this->circuit->parish->id,
                $this->circuit->id,
            ]
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentSubResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'key' => $this->id ?? null,
            'code' => $this->code ?? null,
            'display_name' => $this->display_name ?? null,
            'name' => $this->name ?? null,
            'dependences' => [
                $this->circuit->parish->city->province->id ?? null,
                $this->circuit->parish->city->id ?? null,
                $this->circuit->parish->id ?? null,
                $this->circuit->id ?? null,
                $this->id ?? null
            ]
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DependencePreviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'subcircuit'    => $this->display_name,
            'circuit'       => $this->circuit->display_name,
            'parish'        => $this->circuit->parish->display_name,
            'city'          => $this->circuit->parish->city->display_name,
            'province'      => $this->circuit->parish->city->province->display_name
        ];
    }
}

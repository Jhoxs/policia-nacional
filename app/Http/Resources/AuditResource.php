<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'identificacion_responsable' => $this->user->identification,
            'nombre_responsable'         => $this->user->full_name,
            'email_responsable'          => $this->user->email,
            'accion'                     => $this->action,
            'detail'                     => $this->detail,
            'fecha_creacion'             => $this->created_at,
        ];
    }
}

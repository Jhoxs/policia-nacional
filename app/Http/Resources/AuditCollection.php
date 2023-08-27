<?php
 
namespace App\Http\Resources;
 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;
 
class AuditCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->collection->map(function($item){
            
            return [
                'identificacion_responsable' => $item->user->identification,
                'nombre_responsable'         => $item->user->full_name,
                'email_responsable'          => $item->user->email,
                'accion'                     => $item->action,
                'detail'                     => $item->detail,
                'fecha_creacion'             => $item->created_at,
            ];
        });
    }
}
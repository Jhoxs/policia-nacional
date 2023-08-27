<?php
 
namespace App\Http\Resources;
 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
 
class UserResourcePreview extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        
        $roles       = $this->roles->pluck(['name']);
        $subcircuits = $this->subcircuits->pluck(['display_name']);

        $carbon             = Carbon::parse($this->birthdate)->locale('es');
        $fecha_transformada = $carbon->isoFormat('D \d\e MMMM \d\e YYYY');
        $date_to_form       = date('Y-m-d',strtotime($this->birthdate));

        return [
            'key'               => $this->id,
            'name'              => $this->name,
            'last_name'         => $this->last_name,
            'identification'    => $this->identification,
            'phone'             => $this->phone,
            'email'             => $this->email,
            'rank'              => $this->rank->display_name,
            'blood_type'        => $this->blood_type->display_name,
            'city'              => $this->city->display_name ?? null,
            'roles'             => $roles,
            'birthdate'         => $fecha_transformada,
            'birthdate_form'    => $date_to_form,
            'subcircuit'        => $subcircuits,
            'full_name'         => $this->full_name ?? null
        ];
    
    }
}
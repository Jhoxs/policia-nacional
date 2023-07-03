<?php
 
namespace App\Http\Resources;
 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
 
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        
        $roles = $this->roles->pluck(['name']);

        $carbon = Carbon::parse($this->birthdate)->locale('es');
        $fecha_transformada = $carbon->isoFormat('D \d\e MMMM \d\e YYYY');
        $date_to_form = date('Y-m-d',strtotime($this->birthdate));

        return [
            'key' => $this->id,
            'name' => $this->name,
            'last_name' => $this->last_name,
            'identification'=>$this->identification,
            'phone' => $this->phone,
            'email'=>$this->email,
            'rank' => $this->rank->id,
            'blood_type' => $this->blood_type->id,
            'city'  => $this->city->id,
            'roles' => $roles,
            'birthdate' => $fecha_transformada,
            'birthdate_form' => $date_to_form
        ];
    
    }
}
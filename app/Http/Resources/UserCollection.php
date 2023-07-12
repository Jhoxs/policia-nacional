<?php
 
namespace App\Http\Resources;
 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;
 
class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->collection->map(function($item){
            
            $roles = $item->roles->pluck(['name']);
            $subcircuits = $item->subcircuits->pluck(['display_name']);

            $carbon = Carbon::parse($item->birthdate)->locale('es');
            $fecha_transformada = $carbon->isoFormat('D \d\e MMMM \d\e YYYY');
            
            return [
                'key' => $item->id,
                'name' => $item->name,
                'last_name' => $item->last_name,
                'identification'=>$item->identification,
                'phone' => $item->phone,
                'email'=>$item->email,
                'rank' => $item->rank->display_name,
                'blood_type' => $item->blood_type->display_name,
                'city'  => $item->city->display_name ?? null,
                'roles' => $roles,
                'birthdate' => $fecha_transformada,
                'subcircuits' => $subcircuits,
                'full_name' => $item->full_name ?? null,
            ];
        });
    }
}
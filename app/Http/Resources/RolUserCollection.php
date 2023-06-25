<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RolUserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) 
    {

        return $this->collection->map(function($item){
            /* $roles = $item->roles->map->only(
                'id', 'name'
            ); */
            $roles = $item->roles->pluck(['name']);
            
            return [
                'key' => $item->id,
                'name' => $item->name,
                'identification'=>$item->identification,
                'last_name' => $item->last_name,
                'roles' => $roles,
            ];
        });

    }
}

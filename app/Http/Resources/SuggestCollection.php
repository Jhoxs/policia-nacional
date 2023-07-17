<?php
 
namespace App\Http\Resources;
 
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;
 
class SuggestCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'total' => $this->total,
            'tipo' => $this->tipo,
            'subcircuito' => $this->subcircuito,
            'circuito'=>$this->circuito,
        ];
    
    }
}
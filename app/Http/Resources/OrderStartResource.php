<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\User;

class OrderStartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        $carbon             = Carbon::parse($this->admission_date)->locale('es');
        $date_formatted     = $carbon->isoFormat('D \d\e MMMM \d\e YYYY');
        $schedule           = $carbon->isoFormat('HH:mm');
        $user               = User::find($this->user_id)->first();

        return [
            'key'                       => $this->id,
            'vehicle_id'                => $this->vehicle_id, 
            'user_id'                   => $this->user_id, 
            'img_vehicle'               => asset('/storage/'.$this->img_vehicle), 
            'signature_responsibility'  => asset('/storage/'.$this->signature_responsibility), 
            'detail'                    => $this->detail,
            'admission_date'            => $this->admission_date,
            'current_mileage'           => $this->current_mileage,
            'schedule'                  => $schedule,
            'admission_date_formatted'  => $date_formatted,
            'u_delivery'                => $user
        ];
    }
}

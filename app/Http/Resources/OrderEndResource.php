<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\User;

class OrderEndResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        $carbon             = Carbon::parse($this->departure_date)->locale('es');
        $date_formatted     = $carbon->isoFormat('D \d\e MMMM \d\e YYYY');
        $schedule           = $carbon->isoFormat('HH:mm');
        $user               = User::find($this->user_id);

        return [
            'key'                       => $this->id,
            'vehicle_id'                => $this->vehicle_id, 
            'user_id'                   => $this->user_id, 
            'detail'                    => $this->detail,
            'departure_date'            => $this->departure_date,
            'next_mileage'              => $this->next_mileage,
            'schedule'                  => $schedule,
            'departure_date_formatted'  => $date_formatted,
            'u_receives'                => $user
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\MaintenanceHelper;
use Carbon\Carbon;
use App\Http\Resources\UserResourcePreview;
use App\Http\Resources\VehicleResourcePreview;
use App\Http\Resources\DependencePreviewResource;
use App\Http\Resources\ContractCollection;
use App\Http\Resources\OrderStartCollection;
use App\Http\Resources\OrderStartResource;
use App\Http\Resources\OrderEndResource;
use App\Models\User;
use App\Models\Vehicle;


class MaintenanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        $carbon = Carbon::parse($this->shift_date)->locale('es');
        $fecha_transformada = $carbon->isoFormat('D \d\e MMMM \d\e YYYY');
        $date_to_form = date('Y-m-d',strtotime($this->shift_date));
        $user = User::find($this->user_id);
        $vehicle = Vehicle::find($this->vehicle_id);
        
        return [
            'key'               => $this->id,
            'status_label'      => MaintenanceHelper::statusMaintenaceDictionary($this->status),
            'status'            => $this->status,
            'shift_time_range'  => $this->shift_time_range,
            'shift_date'        => $fecha_transformada,
            'description'       => $this->description,
            'reason_reject'     => $this->reason_reject,
            'user'              => new UserResourcePreview($user),
            'vehicle'           => new VehicleResourcePreview($vehicle),
            'dependence'        => new DependencePreviewResource($user->subcircuits[0]),
            'order_start'       => $this->record_start_maintenance ? new OrderStartResource($this->record_start_maintenance) : null,
            'order_end'         => $this->record_end_maintenance ? new OrderEndResource($this->record_end_maintenance) : null,
            'maintenance_types' => $this->maintenance_types,
            'contracts'         => $this->contracts ? new ContractCollection($this->contracts) : []
        ];
    }
}

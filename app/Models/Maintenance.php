<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Maintenance extends Model
{
    use HasFactory, SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'vehicle_id',
        'shift_date',
        'shift_time_from',
        'shift_time_to',
        'shift_time_range',
        'description',
        'in_progress',
        'status',
        'reason_reject',
        'price',
        'record_start_maintenance_id',
        'record_end_maintenance_id'
    ];


    public function scopeShiftDate($query, $filters)
    {
        $query->where('shift_date', $filters);
    }

    public function scopeRequestMaintenance($query)
    {
        $query->where('status', 0);
    }

    public function scopeNotRejected($query)
    {
        $query->where('status','<>', 1);
    }

    public function scopeShiftRangeDate($query, $filters)
    {
        $query->where('shift_time_range', $filters);
    }

    public function scopeInfo($query)
    {
        $query->with(['vehicle','user']);
    }

    public function scopeProgressing($query)
    {
        $query->where('in_progress',1);
    }

    public function scopeFinished($query)
    {
        $query->where('in_progress',0);
    } 

    public function scopeUserManager($query, $user)
    {
        $query->when( !$user->can('maintenance.manager'), function($query) use ($user) {  
            $query->where('user_id', $user->id);
        });
    }
    
    
    /**
     * Obtenemos el usuario al que pertenece el mantenimiento.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenemos el vehiculo al que pertenece el mantenimiento.
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Obtenemos el registro de entrada del mantenimiento mantenimiento.
     */
    public function record_start_maintenance(): BelongsTo
    {
        return $this->BelongsTo(RecordStartMaintenance::class);
    }

    /**
     * Obtenemos el registro de salida del mantenimiento.
     */
    public function record_end_maintenance(): BelongsTo
    {
        return $this->BelongsTo(RecordEndMaintenance::class);
    }

    /**
     * Los tipos de mantenimiento que tiene un mantenimiento
     */
    public function maintenance_types(): BelongsToMany
    {
        return $this->belongsToMany(MaintenanceType::class);
    }
    
    /**
     * Los contratos que tiene un mantenimiento
     */
    public function contracts(): BelongsToMany
    {
        return $this->belongsToMany(Contract::class);
    }

    public function scopeSearchBar($query, $filters)
    {
        $query->when(isset($filters['value']) && $filters['key'] , function($query) use ($filters) {
            if($filters['key'] == 'identification'){
                $query->join('users','users.id','user_id')->where('users.identification','like','%'.$filters['value'].'%');
            }else if($filters['key'] == 'plate'){
                $query->join('vehicles','vehicles.id','vehicle_id')->where('vehicles.plate','like','%'.$filters['value'].'%');
            }
        })->when($filters['filter'] ?? null, function($query, $filter){
            if($filter == 'cero'){
                $query->where('status',0);
            }elseif(in_array($filter,[1,2,3,4])){
                $query->where('status',$filter);
            }
        });
    }
}

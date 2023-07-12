<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'plate',
        'chassis',
        'brand',
        'model',
        'motor',
        'mileage',
        'next_mileage',
        'cylinder_capacity',
        'loading_capacity',
        'passenger_capacity',
        'vehicle_type_id'
    ];

    /**
    * Obtenemos el tipo de vehiculo al que pertenece.
    */
    public function vehicle_type(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class);
    }

    /**
     * Los subcircuitos a los que pertenecen un vehiculo.
     */
    public function subcircuits(): BelongsToMany
    {
        return $this->belongsToMany(Subcircuit::class);
    }

    /**
     * Los usuarios a los que pertenecen un vehiculo.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function scopeVehicleInfo($query)
    {
        $query->with(['vehicle_type','subcircuits','users']);
    }

    public function scopeWithSubc($query)
    {
        $query->with('subcircuits');
    }

    public function scopeWithCity($query)
    {
        $query->with('subcircuits.circuit.parish.city.province');
    }

    public function scopeHaveSubc($query)
    {
        $query->whereHas('subcircuits');
    }

    public function scopeNotSubc($query)
    {
        $query->whereDoesntHave('subcircuits');
    }
    
    public function scopeHaveUser($query)
    {
        $query->whereHas('users');
    }

    public function scopeNotUser($query)
    {
        $query->whereDoesntHave('users');
    }

    public function scopeSearchBar($query, $filters)
    {
        $query->when(isset($filters['value']) && $filters['key'] , function($query) use ($filters) {
            if($filters['key'] == 'vehicle_type'){
                $query->whereHas($filters['key'], function($query) use ($filters){
                    $query->where('name','like','%'.$filters['value'].'%');
                });
            }else{
                $query->where($filters['key'],'like','%'.$filters['value'].'%');
                
            }
        })->when($filters['filter'] ?? null, function($query, $filter){
            if($filter == 'conSub'){
                $query->haveSubc();
            }elseif($filter == 'sinSub'){
                $query->notSubc();
            }elseif($filter == 'conUsr'){
                $query->haveUser();
            }elseif($filter == 'sinUsr'){
                $query->notUser();
            }
        });
    }

}

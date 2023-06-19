<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

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
    public function vehicleType(): BelongsTo
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
}

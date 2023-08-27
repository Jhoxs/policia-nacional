<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MaintenanceType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'maintenance_types';

    protected $fillable = [
        'name',
        'price',
        'detail'
    ];

    protected $casts = [
        'detail'  =>  'array'
    ];

    /**
     * Los maintenimientos a los que pertenece un tipo de mantenimiento.
     */
    public function maintenances(): BelongsToMany
    {
        return $this->belongsToMany(Maintenance::class);
    }


    
}

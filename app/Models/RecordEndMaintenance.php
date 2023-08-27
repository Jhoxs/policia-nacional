<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RecordEndMaintenance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'record_end_maintenances';

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'detail',
        'next_mileage',
        'departure_date',          
    ];
    
    public function maintenance(): HasOne
    {
        return $this->hasOne(Maintenance::class);
    }

}

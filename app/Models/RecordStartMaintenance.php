<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RecordStartMaintenance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'record_start_maintenances';

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'img_vehicle',
        'signature_responsibility',
        'detail',
        'admission_date',
        'current_mileage'           
    ];

    public function maintenance(): HasOne
    {
        return $this->hasOne(Maintenance::class);
    }
}

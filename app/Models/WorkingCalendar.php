<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingCalendar extends Model
{
    use HasFactory;

    protected $table = 'working_calendar';

    protected $casts = [
        'calendar'  =>  'array'
    ];

    public function scopeIsActive($query)
    {
        $query->where('is_active',1);
    }


}

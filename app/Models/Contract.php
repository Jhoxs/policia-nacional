<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contract extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'detail'
    ];

    /**
     * Los repuestos que puede tener un contrato.
     */
    public function spares(): BelongsToMany
    {
        return $this->belongsToMany(Spare::class);
    }

    public function scopeInfo($query)
    {
        $query->with(['spares']);
    }

    public function scopeSearchBar($query, $filters)
    {
        $query->when(isset($filters['value']) && $filters['key'] , function($query) use ($filters) {
            if($filters['key'] == 'name'){
                $query->where('name','like','%'.$filters['value'].'%');
            }
        });
    }
}

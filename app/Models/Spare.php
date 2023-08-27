<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Spare extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'brand',
        'detail'
    ];

    /**
     * Los repuestos a los que pertenece un contrato.
     */
    public function contracts(): BelongsToMany
    {
        return $this->belongsToMany(Contract::class);
    }

    public function scopeSearchBar($query, $filters)
    {
        $query->when(isset($filters['value']) && $filters['key'] , function($query) use ($filters) {
            if($filters['key'] == 'name'){
                $query->where('name','like','%'.$filters['value'].'%');
            }
            else if($filters['key'] == 'brand'){
                $query->where('brand','like','%'.$filters['value'].'%');
            }
        });
    }
}

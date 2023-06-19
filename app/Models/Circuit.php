<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Circuit extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'display_name'
    ];

    /**
     * Obtenemos los subcircuitos de un circuito.
     */
    public function subcircuits(): HasMany
    {
        return $this->hasMany(Subcircuit::class);
    }

    /**
     * Obtenemos la parroquia a la que pertenece un circuito.
     */
    public function parish(): BelongsTo
    {
        return $this->belongsTo(Parish::class);
    }
}

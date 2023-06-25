<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use App\Traits\ItemsCache;

class Rank extends Model
{
    use HasFactory, ItemsCache;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->modelName = class_basename($this);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'display_name'
    ];

    /**
     * Metodos utilizados al inicializar el modelo.
     */
    protected static function boot()
    {
        parent::boot();

        // Evento después de crear un registro
        static::created(function ($model) {
            $model->removeMenuFromCache();
        });

        // Evento después de actualizar un registro
        static::updated(function ($model) {
            $model->removeMenuFromCache();
        });

        // Evento después de actualizar un registro
        static::deleted(function ($model) {
            $model->removeMenuFromCache();
        });
    }

    /**
     * Obtenemos los usuarios de un rango.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}

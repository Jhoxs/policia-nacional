<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\ItemsCache;

class Parish extends Model
{
    use HasFactory, ItemsCache;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->modelName = class_basename($this);
    }

    /**
     * Metodos utilizados al inicializar el modelo.
     */
    protected static function boot()
    {
        parent::boot();

        // Evento después de crear un registro
        static::created(function ($model) {
            $model->removeMenuFromCache();
            $model->removeMenuFromCacheByModelName(class_basename(Circuit::class));
            $model->removeMenuFromCacheByModelName(class_basename(Subcircuit::class));
        });

        // Evento después de actualizar un registro
        static::updated(function ($model) {
            $model->removeMenuFromCache();
            $model->removeMenuFromCacheByModelName(class_basename(Circuit::class));
            $model->removeMenuFromCacheByModelName(class_basename(Subcircuit::class));
        });

        // Evento después de actualizar un registro
        static::deleted(function ($model) {
            $model->removeMenuFromCache();
            $model->removeMenuFromCacheByModelName(class_basename(Circuit::class));
            $model->removeMenuFromCacheByModelName(class_basename(Subcircuit::class));
        });

        //Evento cuando se está eliminando
        static::deleting(function ($model) {

            $model->circuits()->each(function ($parish) {
                $parish->subcircuits()->delete();
            });
        
            $model->circuits()->delete();
        });
    }


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
        'display_name',
        'city_id'
    ];

    /**
     * Obtenemos los circuitos que de una parroquia (distrito).
     */
    public function circuits(): HasMany
    {
        return $this->hasMany(Circuit::class);
    }

    /**
     * Obtenemos la ciudad a la que pertenece una parroquia.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function scopeWithDep($query)
    {
        $query->with('city.province');
    }

    public function scopeSearchBar($query, $filters)
    {
        $query->when(isset($filters['value']) && $filters['key'] , function($query) use ($filters) {
            if($filters['key'] == 'province'){
                $query->whereHas('city.province', function($query) use ($filters){
                    $query->where('display_name','like','%'.$filters['value'].'%');
                });
            }else if($filters['key'] == 'city'){
                $query->whereHas('city', function($query) use ($filters){
                    $query->where('display_name','like','%'.$filters['value'].'%');
                });
            }else{
                $query->where('display_name','like','%'.$filters['value'].'%');
            }
        });
    }
}

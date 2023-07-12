<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\ItemsCache;

class City extends Model
{
    use HasFactory, ItemsCache;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->modelName = class_basename($this);
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
        'name',
        'display_name',
        'province_id'
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
            $model->removeMenuFromCacheByModelName(class_basename(Parish::class));
            $model->removeMenuFromCacheByModelName(class_basename(Circuit::class));
            $model->removeMenuFromCacheByModelName(class_basename(Subcircuit::class));
        });

        // Evento después de actualizar un registro
        static::updated(function ($model) {
            $model->removeMenuFromCache();
            $model->removeMenuFromCacheByModelName(class_basename(Parish::class));
            $model->removeMenuFromCacheByModelName(class_basename(Circuit::class));
            $model->removeMenuFromCacheByModelName(class_basename(Subcircuit::class));
        });

        // Evento después de actualizar un registro
        static::deleted(function ($model) {
            $model->removeMenuFromCache();
            $model->removeMenuFromCacheByModelName(class_basename(Parish::class));
            $model->removeMenuFromCacheByModelName(class_basename(Circuit::class));
            $model->removeMenuFromCacheByModelName(class_basename(Subcircuit::class));
        });

        //Evento cuando se está eliminando
        static::deleting(function ($model) {
            $model->parishes()->each(function ($parish) {
                $parish->circuits()->each(function ($circuit) {
                    $circuit->subcircuits()->delete();
                });
                $parish->circuits()->delete();
            });
            
            $model->users()->update([
                'city_id' => null
            ]);
            $model->parishes()->delete();
        });
    }

    /**
     * Obtenemos las parroquias que pertenecen a una ciudad.
     */
    public function parishes(): HasMany
    {
        return $this->hasMany(Parish::class);
    }

    /**
     * Obtenemos los usuarios de una ciudad.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Obtenemos la provincia a la que pertenece una ciudad.
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function scopeWithDep($query)
    {
        $query->with('province');
    }

    public function scopeSearchBar($query, $filters)
    {
        $query->when(isset($filters['value']) && $filters['key'] , function($query) use ($filters) {
            if($filters['key'] == 'province'){
                $query->whereHas('province', function($query) use ($filters){
                    $query->where('display_name','like','%'.$filters['value'].'%');
                });
            }else{
                $query->where('display_name','like','%'.$filters['value'].'%');
            }
        });
    }
}

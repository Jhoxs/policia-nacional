<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\ItemsCache;

class Province extends Model
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
            $model->removeMenuFromCacheByModelName(class_basename(City::class));
            $model->removeMenuFromCacheByModelName(class_basename(Parish::class));
            $model->removeMenuFromCacheByModelName(class_basename(Circuit::class));
            $model->removeMenuFromCacheByModelName(class_basename(Subcircuit::class));
        });

        // Evento después de actualizar un registro
        static::updated(function ($model) {
            $model->removeMenuFromCache();
            $model->removeMenuFromCacheByModelName(class_basename(City::class));
            $model->removeMenuFromCacheByModelName(class_basename(Parish::class));
            $model->removeMenuFromCacheByModelName(class_basename(Circuit::class));
            $model->removeMenuFromCacheByModelName(class_basename(Subcircuit::class));
        });

        // Evento después de actualizar un registro
        static::deleted(function ($model) {
            $model->removeMenuFromCache();
            $model->removeMenuFromCacheByModelName(class_basename(City::class));
            $model->removeMenuFromCacheByModelName(class_basename(Parish::class));
            $model->removeMenuFromCacheByModelName(class_basename(Circuit::class));
            $model->removeMenuFromCacheByModelName(class_basename(Subcircuit::class));
        });

        //Evento cuando se está eliminando
        static::deleting(function ($model) {
            $model->cities()->each(function($city){
                $city->parishes()->each(function ($parish) {
                    $parish->circuits()->each(function ($circuit) {
                        $circuit->subcircuits()->delete();
                    });
                    $parish->circuits()->delete();
                });
                
                $city->parishes()->delete();
                //Ponemos en null la llave foranea de usuarios 
                $city->users()->update([
                    'city_id' => null
                ]);
            });
            
            $model->cities()->delete();
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
        'name',
        'display_name'
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function scopeWithDep($query)
    {
        $query->with('cities.parishes.circuits');
    }

    public function scopeWithDepFull($query)
    {
        $query->with('cities.parishes.circuits.subcircuits');
    }

    public function scopeWhereHasDep($query)
    {
        $query->whereHas('cities.parishes.circuits');
    }

    public function scopeWhereHasDepFull($query)
    {
        $query->whereHas('cities.parishes.circuits.subcircuits');
    }
    
    public function scopeWhereHasCircuit($query)
    {
        $query->whereHas('cities.parishes');
    }

    public function scopeWhereHasParish($query)
    {
        $query->whereHas('cities');
    }
    
    public function scopeSearchBar($query, $filters)
    {
        $query->when(isset($filters['value']) && $filters['key'] , function($query) use ($filters) {
            
            $query->where('display_name','like','%'.$filters['value'].'%');
            
        });
    }


}

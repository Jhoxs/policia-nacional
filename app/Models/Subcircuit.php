<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\ItemsCache;

class Subcircuit extends Model
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
        });

        // Evento después de actualizar un registro
        static::updated(function ($model) {
            $model->removeMenuFromCache();
        });

        // Evento después de actualizar un registro
        static::deleted(function ($model) {
            $model->removeMenuFromCache();
        });

        // Evento después de actualizar un registro
        static::deleting(function ($model) {
            $model->removeMenuFromCache();
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
        'circuit_id'
    ];

    /**
     * Obtenemos la relacion de los usuarios que pertenecen a ese subcircuito.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Obtenemos la relacion de los vehiculos que pertenecen a ese subcircuito.
     */
    public function vehicles(): BelongsToMany
    {
        return $this->belongsToMany(Vehicle::class);
    }

    /**
     * Obtenemos el circuito al que pertenecen los subcircuitos.
     */
    public function circuit(): BelongsTo
    {
        return $this->belongsTo(Circuit::class);
    }

    public function scopeWithDep($query)
    {
        $query->with('circuit.parish.city.province');
    }

    public function scopeSearchBar($query, $filters)
    {
        $query->when(isset($filters['value']) && $filters['key'] , function($query) use ($filters) {
            if($filters['key'] == 'province'){
                $query->whereHas('circuit.parish.city.province', function($query) use ($filters){
                    $query->where('display_name','like','%'.$filters['value'].'%');
                });
            }else if($filters['key'] == 'city'){
                $query->whereHas('circuit.parish.city', function($query) use ($filters){
                    $query->where('display_name','like','%'.$filters['value'].'%');
                });
            }else if($filters['key'] == 'parish'){
                $query->whereHas('circuit.parish', function($query) use ($filters){
                    $query->where('display_name','like','%'.$filters['value'].'%');
                });
            }else if($filters['key'] == 'circuit'){
                $query->whereHas('circuit', function($query) use ($filters){
                    $query->where('display_name','like','%'.$filters['value'].'%');
                });
            }else{
                $query->where('display_name','like','%'.$filters['value'].'%');
            }
        });
    }
}

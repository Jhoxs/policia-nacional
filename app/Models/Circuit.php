<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\ItemsCache;

class Circuit extends Model
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

        //Evento cuando se está eliminando
        static::deleting(function ($model) {
            $model->subcircuits()->delete();
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
        'parish_id'
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

    public function scopeWithDep($query)
    {
        $query->with('parish.city.province');
    }

    public function scopeSearchBar($query, $filters)
    {
        $query->when(isset($filters['value']) && $filters['key'] , function($query) use ($filters) {
            if($filters['key'] == 'province'){
                $query->whereHas('parish.city.province', function($query) use ($filters){
                    $query->where('display_name','like','%'.$filters['value'].'%');
                });
            }else if($filters['key'] == 'city'){
                $query->whereHas('parish.city', function($query) use ($filters){
                    $query->where('display_name','like','%'.$filters['value'].'%');
                });
            }else if($filters['key'] == 'parish'){
                $query->whereHas('parish', function($query) use ($filters){
                    $query->where('display_name','like','%'.$filters['value'].'%');
                });
            }else{
                $query->where('display_name','like','%'.$filters['value'].'%');
            }
        });
    }
}

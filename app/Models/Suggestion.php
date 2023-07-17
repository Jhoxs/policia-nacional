<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Suggestion extends Model
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
        'subcircuit_id',
        'catalog_item_id',
        'description',
        'name',
        'last_name',
    ];

    /**
    * Obtenemos el nombre completo.
    */
    public function getFullNameAttribute()
    {
        return $this->name.' '.$this->last_name;
    }

     /**
     * Obtenemos el tipo de dato (Sugerencia/reclamo) al que pertenece ese formulario.
     */
    public function catalog_item(): BelongsTo
    {
        return $this->belongsTo(CatalogItem::class);
    }

    /**
     * Obtenemos el subcircuito al que pertenece este formulario.
     */
    public function subcircuit(): BelongsTo
    {
        return $this->belongsTo(Rank::class);
    }

    
    public function scopeWithCircuits($query)
    {
        $query->with('subcircuit');
    }

    public function scopeSuggestInfo($query)
    {
        $query->with(['catalog_item']);
    }

    public function scopeHaveSugg($query)
    {
        $query->where('catalog_item_id','1');
    }

    public function scopeHaveClaim($query)
    {
        $query->where('catalog_item_id','2');
    }    

    public function scopeGroupByTotal($query){
        $query->groupBy('subcircuit_id','catalog_item_id');
    }

    public function scopeFilterDate($query, $filters){

        $query->when(isset($filter['from_date']) && isset($filter['to_date']), function($query) use ($filters){
            $query->whereBetween('created_at',[$filters['from_date'],$filters['to_date']]);
        });
    }

    public function scopeSearchBar($query, $filters)
    {
        $query->when(isset($filters['value']) && $filters['key'] , function($query) use ($filters) {
            if($filters['key'] == 'vehicle_type'){
                $query->whereHas($filters['key'], function($query) use ($filters){
                    $query->where('name','like','%'.$filters['value'].'%');
                });
            }else{
                $query->where($filters['key'],'like','%'.$filters['value'].'%');
                
            }
        })->when($filters['filter'] ?? null, function($query, $filter){
            if($filter == 'conSub'){
                $query->haveSubc();
            }elseif($filter == 'sinSub'){
                $query->notSubc();
            }elseif($filter == 'conUsr'){
                $query->haveUser();
            }elseif($filter == 'sinUsr'){
                $query->notUser();
            }
        });
    }

}

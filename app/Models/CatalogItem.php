<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CatalogItem extends Model
{
    use HasFactory;

    protected $table = 'catalog_items';

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
    ];

    /**
     * Obtenemos las suggerencias de una ciudad.
     */
    public function suggestions(): HasMany
    {
        return $this->hasMany(Suggestion::class);
    }


    public function scopeSuggest($query)
    {
        $query->where('name','suggestion_item');
    }



}

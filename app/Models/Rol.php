<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

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
     * Los usuarios que pertenecen al rol.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'identification',
        'phone',
        'birthdate',
        'city_id',
        'blood_type_id',
        'rank_id',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birthdate' => 'date:Y-m-d',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Obtenemos el tipo de sangre al que pertenece un usuario.
     */
    public function blood_type(): BelongsTo
    {
        return $this->belongsTo(BloodType::class);
    }

    /**
     * Obtenemos el rango al que pertenece un usuario.
     */
    public function rank(): BelongsTo
    {
        return $this->belongsTo(Rank::class);
    }

    /**
     * Obtenemos la ciudad al que pertenece un usuario.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Los roles que pertenecen al usuario.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Los subcircuitos a los que pertenecen un usuario.
     */
    public function subcircuits(): BelongsToMany
    {
        return $this->belongsToMany(Subcircuit::class);
    }
}

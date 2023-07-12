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
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
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

    protected $appends = [
        'full_name'
    ];

    /**
     * Obtenemos el nombre completo.
     */
    public function getFullNameAttribute()
    {
        return $this->name.' '.$this->last_name;
    }


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
     * Los usuarios y los roles a los que pertenecen.
     */
    public function roles_users_list($pages = 10)
    {
        return $this->with('roles')->whereHas('roles')->paginate($pages);
    }

    /**
     * Los subcircuitos a los que pertenecen un usuario.
     */
    public function subcircuits(): BelongsToMany
    {
        return $this->belongsToMany(Subcircuit::class);
    }

    /**
     * Los usuarios a los que pertenece un vehiculo.
     */
    public function vehicles(): BelongsToMany
    {
        return $this->belongsToMany(Vehicle::class);
    }

    

    public function show_table_list($pages = 10)
    {
        return $this->with('blood_type')->with('rank')->with('city')->with('roles')->paginate($pages);
    }

    public function show_user_info($id)
    {
        return $this->with('blood_type')->with('rank')->with('city')->with('roles')->where('id',$id)->first();
    }

    public function scopeWithSubc($query)
    {
        $query->with('subcircuits');
    }

    public function scopeSameCity($query,$cities)
    {
        $query->whereHas('subcircuits.circuit.parish.city', function ($query) use ($cities) {
            $query->where('id', $cities);
        });
    }

    public function scopeHaveSubc($query)
    {
        $query->whereHas('subcircuits');
    }

    public function scopeNotSubc($query)
    {
        $query->whereDoesntHave('subcircuits');
    }

    public function scopeNotVehicle($query)
    {
        $query->whereDoesntHave('vehicles');
    }

    public function scopeUserInfo($query)
    {
        $query->with(['blood_type','rank','city','roles','subcircuits']);
    }

    public function scopeSearchBar($query, $filters)
    {
        $query->when(isset($filters['value']) && $filters['key'] , function($query) use ($filters) {
            if(in_array($filters['key'],['identification','email'])){
                $query->where($filters['key'],'like','%'.$filters['value'].'%');
            }else if($filters['key'] == 'name'){
                $query->where('name','like','%'.$filters['value'].'%')
                        ->orWhere('last_name','like','%'.$filters['value'].'%');
            }
            else{
                $query->whereHas($filters['key'], function($query) use ($filters){
                    $query->where('name','like','%'.$filters['value'].'%');
                });
            }
        })->when($filters['filter'] ?? null, function($query, $filter){
            if($filter == 'conSub'){
                $query->haveSubc();
            }elseif($filter == 'sinSub'){
                $query->notSubc();
            }
        });
    }
}

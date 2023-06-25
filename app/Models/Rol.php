<?php

namespace App\Models;

use Spatie\Permission\Models\Role;

class Rol extends Role
{


    public function getListRoleCount()
    {
        return static::withCount('users')->get();
    }
}
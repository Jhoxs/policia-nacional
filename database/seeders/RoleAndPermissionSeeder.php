<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create([
            'name' => 'Administrador'
        ]);
        $auxiliar = Role::create([
            'name' => 'Auxiliar'
        ]);
        $gerencia = Role::create([
            'name' => 'Gerencia'
        ]);
        $personal = Role::create([
            'name' => 'Personal'
        ]);

        Permission::create([
            'name' => 'home'
        ])->syncRoles([$admin,$auxiliar,$gerencia,$personal]);
        Permission::create([
            'name' => 'users.index'
        ])->syncRoles([$admin]);
        Permission::create([
            'name' => 'users.create'
        ])->syncRoles([$admin]);
        Permission::create([
            'name' => 'users.edit'
        ])->syncRoles([$admin]);
        Permission::create([
            'name' => 'users.destroy'
        ])->syncRoles([$admin]);
    }
}

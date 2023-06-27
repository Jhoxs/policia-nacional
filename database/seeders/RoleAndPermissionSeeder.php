<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Creamos los Roles
        $admin = Role::updateOrCreate([
            'name' => 'Administrador'
        ]);
        $auxiliar = Role::updateOrCreate([
            'name' => 'Auxiliar'
        ]);
        $gerencia = Role::updateOrCreate([
            'name' => 'Gerencia'
        ]);
        $personal = Role::updateOrCreate([
            'name' => 'Personal'
        ]);

        //Creamos los permisos para la aplicacion
        Permission::updateOrCreate([
            'name' => 'dashboard.index'
        ])->syncRoles([$admin,$auxiliar,$gerencia,$personal]);
        Permission::updateOrCreate([
            'name' => 'users.index'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'users.create'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'users.edit'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'users.destroy'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'rol.index'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'rol.create'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'rol.store'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'rol.edit'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'rol.destroy'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'rol.show'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'rol.update'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'rol.updateUserRol'
        ])->syncRoles([$admin]);
        

        //Asignamos el rol por defecto al administrador
        $user = User::find(1);
        $user->assignRole('Administrador');
        $user = User::find(2);
        $user->assignRole('Auxiliar');
        $user = User::find(3);
        $user->assignRole('Gerencia');
        $user = User::find(4);
        $user->assignRole('Personal');
    }
}

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

        //PERMISOS PARA USUARIOS
        Permission::updateOrCreate([
            'name' => 'user.index'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'user.create'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'user.store'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'user.show'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'user.edit'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'user.update'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'user.destroy'
        ])->syncRoles([$admin]);

        //PERMISOS PARA VEHICULOS
        Permission::updateOrCreate([
            'name' => 'vehicle.index'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'vehicle.create'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'vehicle.store'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'vehicle.show'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'vehicle.edit'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'vehicle.update'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'vehicle.destroy'
        ])->syncRoles([$admin]);

        //PERMISOS PARA LOS ROLES
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
        $users = User::where('id','>',3)->get();
        foreach($users as $u){
            $u->assignRole('Personal');
        }
    }
}

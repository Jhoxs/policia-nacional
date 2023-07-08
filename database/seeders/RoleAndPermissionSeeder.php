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

        //PERMISOS PARA SUBCIRCUITOS
        Permission::updateOrCreate([
            'name' => 'dependence.index'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'subcircuit.index'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'subcircuit.create'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'subcircuit.store'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'subcircuit.edit'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'subcircuit.destroy'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'subcircuit.show'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'subcircuit.update'
        ])->syncRoles([$admin]);
        
        //PERMISOS PARA CIRCUITOS
        Permission::updateOrCreate([
            'name' => 'circuit.index'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'circuit.create'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'circuit.store'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'circuit.edit'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'circuit.destroy'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'circuit.show'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'circuit.update'
        ])->syncRoles([$admin]);

        //PERMISOS PARA PARROQUIAS
        Permission::updateOrCreate([
            'name' => 'parish.index'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'parish.create'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'parish.store'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'parish.edit'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'parish.destroy'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'parish.update'
        ])->syncRoles([$admin]);
        
        //PERMISOS PARA CIUDADES
        Permission::updateOrCreate([
            'name' => 'city.index'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'city.create'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'city.store'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'city.edit'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'city.destroy'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'city.update'
        ])->syncRoles([$admin]);
        
        //PERMISOS PARA PROVINCIAS
        Permission::updateOrCreate([
            'name' => 'province.index'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'province.create'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'province.store'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'province.edit'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'province.destroy'
        ])->syncRoles([$admin]);
        Permission::updateOrCreate([
            'name' => 'province.update'
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

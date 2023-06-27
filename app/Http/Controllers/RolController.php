<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Rol;
use App\Models\User;
use App\Http\Resources\RolCollection;
use App\Http\Resources\RolUserCollection;
use App\Http\Resources\PermissionCollection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Redirect;


class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : Response
    {
        
        $rolList = (new Rol)->getListRoleCount();
        $userList = (new User)->roles_users_list(10);
        
        return Inertia::render('Roles/Index',[ 
            'rolList' => new RolCollection($rolList), 
            'userList' => new RolUserCollection($userList)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = (new Permission)::getPermissions();

        return Inertia::render('Roles/Create',[ 
            'permissionsList' => new PermissionCollection($permissions)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:Spatie\Permission\Models\Role,name',
            'permission' => 'required|exists:Spatie\Permission\Models\Permission,name',
        ],[
            'name.required'=>'El nombre del Rol es requerido',
            'name.unique' => 'Ya existe un rol con este nombre',
            'permission.required' => 'Debes seleccionar al menos un permiso',
            'permission.exists' => 'El permiso seleccionado no coincide con nuestros registros',
        ]);

        Role::create([
            'name' => $request->name
        ])->syncPermissions($request->permission);

        return to_route('rol.index')->with('success', 'Rol agregado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::select('id','name','last_name','identification')->find($id);
        $userRol = $user->getRoleNames();
        $rolList = Role::select('name as value','name as label')->get();
        return Inertia::render('Roles/EditUserRol',[
            'userInfo' => $user,
            'rolList' => $rolList,
            'userRol' => $userRol
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rol = Role::select('id','name')->find($id);
        $permissions_rol = $rol->permissions->pluck(['name']);
        $permissions = (new Permission)::getPermissions();
        
        return Inertia::render('Roles/Edit',[
            'permissionsList' => new PermissionCollection($permissions),
            'permissionsDefault' => $permissions_rol,
            'rolInfo' =>  $rol
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:Spatie\Permission\Models\Role,name',
            'permission' => 'required|exists:Spatie\Permission\Models\Permission,name',
        ],[
            'name.required'=>'El nombre del Rol es requerido',
            'name.unique' => 'Ya existe un rol con este nombre',
            'permission.required' => 'Debes seleccionar al menos un permiso',
            'permission.exists' => 'El permiso seleccionado no coincide con nuestros registros',
        ]);
        
        $rol = Role::find($id);
        $rol->update([
            'name' => $request->name
        ]);
        
        $rol->syncPermissions($request->permission);

        return to_route('rol.index')->with('success', 'El rol se actualizó con éxito');

    }

    /**
     * Update the specified user resource in storage.
     */
    public function updateUserRol(Request $request, string $id)
    {
        $request->validate([
            'roles' => 'required|exists:Spatie\Permission\Models\Role,name',
        ],[

            'roles.required' => 'Debes seleccionar al menos un Rol',
            'roles.exists' => 'El Rol seleccionado no coincide con nuestros registros',
        ]);

        $user = User::find($id);
        $user->syncRoles($request->roles);
        return to_route('rol.index')->with('success', 'El rol del usuario se actualizó con éxito');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rol =  Role::find($id);
        $rol->delete();
        return to_route('rol.index')->with('success', 'El rol se ha eliminado con éxito');
    }
}

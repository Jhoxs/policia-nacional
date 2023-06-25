<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Rol;
use App\Models\User;
use App\Http\Resources\RolCollection;
use App\Http\Resources\RolUserCollection;


class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : Response
    {
        
        $rolList = (new Rol)->getListRoleCount();
        $userList = (new User)->roles_users_list(10);
        logger($request->all());
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        logger('entre nuevamente');
        return Inertia::render('Roles/Rol');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

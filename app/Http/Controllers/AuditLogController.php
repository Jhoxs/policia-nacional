<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//MODELOS
use App\Models\AuditLog;

class AuditLogController extends Controller
{
    
    public function store(Request $request)
    {
        $model  = $request->model;
        $action = $request->action;
        $detail = $request->detail ?? null;
        
        // Crear un registro en la tabla de auditoría
        AuditLog::create([
            'user_id'       => Auth::user()->id,
            'model_id'      => $model->id,
            'model_type'    => get_class($model),
            'action'        => $action,
            'detail'        => $detail   
        ]);

    }

}

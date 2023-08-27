<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
//INERTIA
use Inertia\Inertia;
use Inertia\Response;
//MODELS
use App\Models\Vehicle;
use App\Models\User;
use App\Models\AuditLog;
//RESOURCES
use App\Http\Resources\AuditCollection;
use App\Http\Resources\AuditResource;
//EXCEL
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AuditLogsExport;


class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:report.index')->only('index');
        $this->middleware('can:report.download')->only('download');
    }
    

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$modelData = (new Spare)->SearchBar(Rq::only('value','key'))->paginate(10)->appends(Rq::all());

        return Inertia::render('Reports/Index',[ 
            
        ]);
    }

    /**
     * Download report
     */
    public function download(Request $request)
    {
        $request->validate([
            'date_range'    => ['required','array','min:2'],
            'type_report'   => ['required','string','max:255']
        ],[
            'date_range.required'   => 'El rango de fecha es requerido',
            'type_report.required'  => 'El tipo de reporte es requerido' 
        ]);

        $filters = [
            'from_date' => date('Y-m-d',strtotime($request->date_range[0])),
            'to_date'   => date('Y-m-d',strtotime($request->date_range[1]))
        ];
    
        $infoSearch = [
            'user_report'       => User::class,
            'vehicle_report'    => Vehicle::class,
        ];

        $classSearch = $infoSearch[$request->type_report] ?? reset($infoSearch);

        $audit_info  = AuditLog::model($classSearch)->with(['user'])->whereBetween('created_at',$filters)->get();

        $audit_logs = $audit_info->map(function($value, $key) use($filters) {
            return[
                'identificacion_responsable'  => $value->user->identification,
                'nombre_responsable'          => $value->user->full_name,
                'email_responsable'           => $value->user->email,
                'accion'                      => $value->action,
                'detalles'                    => $value->detail,
                'fecha_creacion'              => date('Y-m-d H:m:s',strtotime($value->created_at)),
                'fecha_inicio'                => $filters['from_date'],
                'fecha_fin'                   => $filters['to_date'],
            ];
            
        });

        if(count($audit_info)){
            $audit_logs_export = new AuditLogsExport($audit_logs);

            $data = [
                'alert-type'    => 'success',
                'message'       => 'Se encontraron un total de '.count($audit_info).' registros.',
                'excel'         
            ];
            return Excel::download($audit_logs_export,'reporte_sistema.xlsx');

        }else{
            $data = [
                'message'           => "No se encontraron datos en el rango especificado.",
                'alert-type'        => 'warning',
            ];
            
            return response()->json($data,'204');
        }

    }

}

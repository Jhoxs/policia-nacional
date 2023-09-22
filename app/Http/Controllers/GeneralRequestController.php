<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Request as Rq;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Vehicle;
use App\Models\VehicleType;
use App\Models\User;
use App\Models\WorkingCalendar;
use App\Models\Maintenance;
use App\Http\Resources\VehicleCollection;
use App\Http\Resources\VehicleResource;
use App\Http\Requests\CreateSubcircuitRequest;
use App\Http\Requests\UpdateSubcircuitRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Http\Requests\MaintenanceFormRequest;
use App\Http\Resources\SubcircuitCollection;
use App\Http\Resources\RequestMaintenanceCollection;
use App\Http\Resources\ProvinceCollection;
use App\Http\Resources\SubcircuitResource;
use App\Models\Province;
use App\Models\City;
use App\Models\Parish;
use App\Models\Circuit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\User\RequestVehicleMailAlert;
use App\Notifications\Maintenance\AcceptMaintenanceNotify;
use App\Notifications\Maintenance\RejectMaintenanceNotify;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResourcePreview;
use App\Http\Resources\VehicleResourcePreview;
use App\Http\Resources\DependencePreviewResource;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


class GeneralRequestController extends Controller
{
    public function __construct()
    {   
        $this->middleware('can:requestmaintenance.index')->only('indexMaintenance');
        
    }

    /**
     * Display a listing of the resource.
     */
    public function indexMaintenance()
    {   
        $maintenance =  Maintenance::requestMaintenance()->info()->paginate(20);

        return Inertia::render('Request/MaintenanceRequest',[ 
            'requestMaintenance' => new RequestMaintenanceCollection($maintenance)
        ]);
    }

    public function storeMaintenance(Request $request)
    {
        $m_info = $request->all();
        $maintenance = Maintenance::find($m_info['idMaintenance']);

        switch($m_info['typeRequest'])
        {
            case 'accept':
                $maintenance->update([  
                    'status' => 2
                ]);
                //Send notify 
                Notification::sendNow($maintenance->user, new AcceptMaintenanceNotify($maintenance));

                return to_route('requestmaintenance.index')->with('success', 'La solicitud se aceptó con éxito');
                break;
            case 'reject':
                $maintenance->update([
                    'status' => 1,
                    'in_progress' => 0,
                    'reason_reject' => $m_info['reasonReject'] ?? null
                ]);
                //Send notify
                Notification::sendNow($maintenance->user, new RejectMaintenanceNotify($maintenance));
                
                return to_route('requestmaintenance.index')->with('success', 'La solicitud ha sido rechazada');
                break;
            default:
                return to_route('requestmaintenance.index')->with('success', 'No se procesaron solicitudes');
        }
    }

}

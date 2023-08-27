<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use App\Models\Circuit;
use App\Models\WorkingCalendar;
use App\Models\Maintenance;
use App\Models\Vehicle;
use Illuminate\Validation\Rule;
use Closure;
use Carbon\Carbon;

class MaintenanceOrderStartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'admission_date_str' => isset($this->admission_date_str) ? date('Y-m-d H:i:s',strtotime($this->admission_date_str)) : null,
        ]);

    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $image_format = ['image/png','image/jpg','image/jpeg','image/svg'];
        $vehicle = Vehicle::find($this->vehicle_id)->first();

        return [
            'current_mileage' => ['required','numeric','gte:'.$vehicle->mileage],
            'c_selected' => ['required','array','min:1','exists:App\Models\Contract,id'],
            'm_types_selected' => ['required','array','exists:App\Models\MaintenanceType,id','min:1', function($att, $value, Closure $fail){
                if(in_array(1,$value) && in_array(2,$value)){
                    $fail('No se puede seleccionar el mantenimiento 1 y 2 al mismo tiempo.');
                }
            }],
            'detail' => ['nullable','string','max:1200'],
            'admission_date_str' => ['required','date','date_format:"Y-m-d H:i:s"'],
            'img_vehicle' => ['required', function($att, $value, Closure $fail) use($image_format){
                if(!isset($value['file']['type'])){
                    $fail('Se debe cargar una imagen');
                }

                if(isset($value['file']['type']) && !in_array($value['file']['type'], $image_format)){
                    $fail('El formato de la carga no es válido');
                }
            }],
            'signature_responsibility' => ['required',function($att, $value, Closure $fail) use($image_format){
                if(!isset($value['file']['type'])){
                    $fail('Se debe cargar una imagen');
                }

                if(isset($value['file']['type']) && !in_array($value['file']['type'], $image_format)){
                    $fail('El formato de la carga no es válido');
                }
            }],
            'user_id'           => ['required','exists:App\Models\User,id'],
            'vehicle_id'        => ['required','exists:App\Models\Vehicle,id'],
            'maintenance_id'    => ['required','exists:App\Models\Maintenance,id'],
            'price'             => ['required','decimal:0,2'],
            'identification'    => ['required','exists:App\Models\User,identification'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            
            'admission_date_str.required'       => 'El horario de ingreso es requerido.',
            'current_mileage.required'          => 'El kilometraje actual es requerido.',
            'm_types_selected.required'         => 'El Tipo de mantenimiento es requerido.',
            'img_vehicle.required'              => 'La imagen del vehículo es requerida.',
            'img_vehicle.image'                 => 'Se debe cargar una imagen.',
            'signature_responsibility.required' => 'La firma de responsabilidad es requerida.',
            'signature_responsibility.image'    => 'Se debe cargar una imagen.',
            'c_selected.required'               => 'El Contrato es requerido.',
            'admission_date_str.date_format'    => 'El Formato de fecha no es el correcto.',
            'identification.required'           => 'La identificación es requerida',
            'identification.exists'             => 'La identificación debe existir en nuestros registros',
        ];
    }
}

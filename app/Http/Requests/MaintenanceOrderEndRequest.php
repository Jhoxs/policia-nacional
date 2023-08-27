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

class MaintenanceOrderEndRequest extends FormRequest
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
        $vehicle = Vehicle::find($this->vehicle_id)->first();

        return [
            'current_mileage'       => ['required','numeric','gte:'.$vehicle->mileage],
            'next_mileage'          => ['required','numeric'],
            'detail'                => ['nullable','string','max:1200'],
            'admission_date_str'    => ['required','date','date_format:"Y-m-d H:i:s"'],
            'user_id'               => ['required','exists:App\Models\User,id'],
            'vehicle_id'            => ['required','exists:App\Models\Vehicle,id'],
            'maintenance_id'        => ['required','exists:App\Models\Maintenance,id'],
            'identification'        => ['required','exists:App\Models\User,identification'],
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
            'next_mileage.required'             => 'El kilometraje actual es requerido.',
            'admission_date_str.date_format'    => 'El Formato de fecha no es el correcto.',
            'identification.required'           => 'La identificación es requerida',
            'identification.exists'             => 'La identificación debe existir en nuestros registros',
        ];
    }
}

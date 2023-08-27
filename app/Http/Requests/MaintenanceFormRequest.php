<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use App\Models\Circuit;
use App\Models\WorkingCalendar;
use App\Models\Maintenance;
use Illuminate\Validation\Rule;
use Closure;
use Carbon\Carbon;

class MaintenanceFormRequest extends FormRequest
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
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $date = $this->shift_date ?? null;
        return [
            'mileage' => ['required','numeric'],
            'shift_date' => ['required','date'],
            'shift_range' => ['required','string','max:255', function($att, $value, Closure $fail) use ($date){
                
                $custom_date = $date;
                $date = $date ?? '2023-01-01';
                $c_date = Carbon::createFromFormat('Y-m-d', $date);
                $dayOfWeek = $c_date->format('l');
                $work_days = WorkingCalendar::isActive()->first()->calendar ?? null;  
                $busy_shift = Maintenance::when(isset($value) && isset($date), function($query) use($date,$value){
                    $query->shiftRangeDate($value)->shiftDate($date)->notRejected();
                })->first();

                if(is_null($custom_date)){
                    $fail("No existe Fecha del Turno para este horario");
                }

                if(isset($busy_shift))
                {
                    $fail("Este turno ya ha sido registrado");
                }

                if(!(isset($work_days[$dayOfWeek]) && in_array($value,$work_days[$dayOfWeek])))
                {
                    $fail("Este rango no existe dentro de los existentes");
                }

            }],
            'description' => ['string','max:1200'],
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
            'mileage.required' => 'El kilometraje es requerido',
            'shift_range.required' => 'El horario del turno es requerido',
            'shift_date.required' => 'La fecha del turno es requerida',
            'description.max' => 'El texto ingresado supera los límites',
            
        ];
    }
}

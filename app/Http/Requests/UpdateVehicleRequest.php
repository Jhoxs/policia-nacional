<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Validation\Rules;

class UpdateVehicleRequest extends FormRequest
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
            'chassis' => trim($this->chassis),
            'plate' => trim(strtoupper($this->plate)),
            'motor' => trim($this->motor),
            'model' => trim($this->model),
            'brand' => trim(strtoupper($this->brand)),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule','array','string>
     */
    public function rules(): array
    {
        return [
            'chassis' => ['required','string','max:255'],
            'brand' => ['required','string','max:255'],
            'model' => ['required','string','max:255'],
            'motor' => ['required','string','max:255'],
            'mileage' => ['required','numeric'],
            'cylinder_capacity' => ['required','numeric','max_digits:10'],
            'loading_capacity' => ['required','numeric','max_digits:10'],
            'passenger_capacity' => ['required','numeric','max_digits:2'],
            'vehicle_type' => ['required','exists:App\Models\VehicleType,id'],
            
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
            'plate.required' => 'La placa es requerida',
            'plate.unique' => 'No pueden haber placas repetidas',
            'chassis.required' => 'El chasis es requerido',
            'brand.required' => 'La marca es requerida',
            'model.required' => 'El modelo es requerido',
            'motor.required' => 'El motor es requerido',
            'mileage.required' => 'El kilometraje es requerido',
            'mileage.numeric' => 'Solo se permiten valores numericos',
            'cylinder_capacity.required' => 'La capacdad de cilindraje es requerida',
            'cylinder_capacity.numeric' => 'Solo se permiten valores numericos',
            'loading_capacity.required' => 'La capacdad de carga es requerida',
            'loading_capacity.numeric' => 'Solo se permiten valores numericos',
            'passenger_capacity.numeric' => 'Solo se permiten valores numericos',
            'passenger_capacity.required' => 'El número de pasajeros es requerido',

        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Validation\Rule;


class UpdateUserRequest extends FormRequest
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
            'birthdate' => date('Y-m-d',strtotime($this->birthdate)),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','string','max:255'],
            'lastname' => ['required','string','max:255'],
            'birthdate' => ['required','date_format:Y-m-d'],
            'city' => ['required','exists:App\Models\City,id'],
            'blood_type' => ['required','exists:App\Models\BloodType,id'],
            'rank' => ['required','exists:App\Models\Rank,id'],
            'roles' => ['required','exists:Spatie\Permission\Models\Role,name'],
            
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
            'name.required' => 'El nombre es requerido',
            'lastname.required' => 'El apellido es requerido',
            'birthdate.required' => 'La fecha de nacimiento es requerida',
            'birthdate.date_format' => 'El formato de fecha no es valido',
            'city.required' => 'La ciudad es requerida',
            'blood_type.required' => 'El tipo de sangre es requerido',
            'rank.required' => 'El rango es requerido',
            'roles.required' => 'Debe seleccionar al menos un Rol',
            'roles.exists' => 'El Rol seleccionado no coincide con nuestros registros',
        ];
    }
}

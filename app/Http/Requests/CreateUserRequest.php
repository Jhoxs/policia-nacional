<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Validation\Rules;

class CreateUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'identification' => 'required|numeric|max_digits:10|unique:App\Models\User,identification',
            'phone' => 'required|numeric|max_digits:10|unique:App\Models\User,phone',
            'birthdate' => 'required|date_format:Y-m-d',
            'city' => 'required|exists:App\Models\City,id',
            'blood_type' => 'required|exists:App\Models\BloodType,id',
            'rank' => 'required|exists:App\Models\Rank,id',
            'email' => 'required|string|email|max:255|unique:App\Models\User,email',
            'roles' => 'required|exists:Spatie\Permission\Models\Role,name',
            
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
            'identification.required' => 'La identificación es requerida',
            'identification.max_digits' => 'La identificación no puede tener más de diez digitos',
            'identification.numeric' => 'La identificación solo acepta elementos numéricos',
            'phone.required' => 'El teléfono es requerido',
            'phone.max_digits' => 'La teléfono no puede tener más de diez digitos',
            'phone.numeric' => 'El teléfono solo acepta elementos numéricos',
            'birthdate.required' => 'La fecha de nacimiento es requerida',
            'birthdate.date_format' => 'El formato de fecha no es valido',
            'city.required' => 'La ciudad es requerida',
            'blood_type.required' => 'El tipo de sangre es requerido',
            'rank.required' => 'El rango es requerido',
            'email.required' => 'El email es requerido',
            'roles.required' => 'Debe seleccionar al menos un Rol',
            'roles.exists' => 'El Rol seleccionado no coincide con nuestros registros',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use App\Models\Circuit;
use Illuminate\Validation\Rule;

class AssignUserSubcircuitRequest extends FormRequest
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
        $model_id = $this->dependence[4] ?? null;
        $this->merge([
            'dependence' => $model_id
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
            'userSelected' => ['required','array','min:1','exists:App\Models\User,id'],
            'dependence' => ['required','numeric','exists:App\Models\Subcircuit,id']
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
            'dependence.required' => 'El subcircuito es requerido es requerido',
            'dependence.exists' => 'El subcircuito no coincide en los registros',
            'userSelected.required' => 'Se debe seleccionar al menos un usuario',
            
        ];
    }
}

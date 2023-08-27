<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use App\Models\Circuit;
use Illuminate\Validation\Rule;

class SuggFormRequest extends FormRequest
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
        $circuit_id = $this->dependence[0] ?? null;
        $subcircuit_id = $this->dependence[1] ?? null;
        $this->merge([
            'dependence' => $subcircuit_id,
            'circuit_id' => $circuit_id,
            'name'       => trim(mb_strtoupper($this->name)),
            'lastname'   => trim(mb_strtoupper($this->lastname)),
            'description'   => trim($this->description),
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
            'description' => ['required','string','max:1200'],
            'type_suggestion' => ['required','numeric','exists:App\Models\CatalogItem,id'],
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
            'name.required' => 'El nombre es requerido',
            'lastname.required' => 'El apellido es requerido',
            'type_suggestion.required' => 'El tipo de solicitud es requerido',
            'type_suggestion.exists' => 'El tipo de solicitud no es existe',
            'description.required' => 'La descripción es requerida',
            
        ];
    }
}

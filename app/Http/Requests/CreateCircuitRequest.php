<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use App\Models\Parish;
use Illuminate\Validation\Rule;

class CreateCircuitRequest extends FormRequest
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
        $parish_id = $this->dependence[2] ?? null;
        $circuit = $parish_id ? Parish::select('code')->find($parish_id) : null;
        $circuit_code =  isset($circuit->code) ? $circuit->code : '';

        $this->merge([
            'name' => Str::slug(trim($this->display_name),'_'),
            //'code' => $circuit_code.$this->code,
            'dependence' => $parish_id
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
            'name' => ['required','string','max:255','max:255','unique:App\Models\Circuit,name'],
            'display_name' => ['required','string','max:255','unique:App\Models\Circuit,display_name'],
            'code' => ['required','string','max:255','max:255','unique:App\Models\Circuit,code'],
            'dependence' => ['required','numeric','exists:App\Models\Parish,id']

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
            'dependence.required' => 'La parroquia es requerida',
            'name.required' => 'El nombre es requerido',
            'display_name.required' => 'El nombre de circuito es requerido',
            'display_name.unique' => 'El circuito ya existe dentro de los registros',
            'code.unique' => 'El código del circuito ya existe dentro de los registros',
            'code.required' => 'El código es requerido',
        ];
    }
}

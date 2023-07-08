<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use App\Models\Parish;
use Illuminate\Validation\Rule;

class CreateParishRequest extends FormRequest
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
        $model_id = $this->dependence[1] ?? null;
        $circuit = $model_id ? Parish::select('code')->find($model_id) : null;
        $circuit_code =  isset($circuit->code) ? $circuit->code : '';

        $this->merge([
            'name' => Str::slug(trim($this->display_name),'_'),
            //'code' => $circuit_code.$this->code,
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
            'name' => ['required','string','max:255','max:255','unique:App\Models\Parish,name'],
            'display_name' => ['required','string','max:255','unique:App\Models\Parish,display_name'],
            'code' => ['required','string','max:255','max:255','unique:App\Models\Parish,code'],
            'dependence' => ['required','numeric','exists:App\Models\City,id']

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
            'dependence.required' => 'La ciudad es requerida',
            'name.required' => 'El nombre es requerido',
            'display_name.required' => 'El nombre de la parroquia es requerido',
            'display_name.unique' => 'La parroquia ya existe dentro de los registros',
            'code.unique' => 'El código de la parroquia ya existe dentro de los registros',
            'code.required' => 'El código es requerido',
        ];
    }
}

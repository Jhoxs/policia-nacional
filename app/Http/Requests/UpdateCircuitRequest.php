<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use App\Models\Circuit;

class UpdateCircuitRequest extends FormRequest
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
        $circuit_id = $this->dependence[2] ?? null;
        $circuit = $circuit_id ? Circuit::select('code')->find($circuit_id) : null;
        $circuit_code =  isset($circuit->code) ? $circuit->code : '';

        $this->merge([
            'name' => Str::slug(trim($this->display_name),'_'),
            //'code' => $circuit_code.$this->code,
            'dependence' => $circuit_id
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
            'dependence' => ['required','numeric','exists:App\Models\Circuit,id']

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
            'dependence.required' => 'La parroquia es requerido',
        ];
    }
}

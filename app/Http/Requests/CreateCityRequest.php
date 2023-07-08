<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use App\Models\Circuit;
use Illuminate\Validation\Rule;

class CreateCityRequest extends FormRequest
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
        $model_id = $this->dependence[0] ?? null;

        $this->merge([
            'name' => Str::slug(trim($this->display_name),'_'),
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
            'name' => ['required','string','max:255','max:255','unique:App\Models\City,name'],
            'display_name' => ['required','string','max:255','unique:App\Models\City,display_name'],
            'dependence' => ['required','numeric','exists:App\Models\Province,id']

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
            'dependence.required' => 'La provincia es requerida',
            'name.required' => 'El nombre es requerido',
            'display_name.required' => 'El nombre de la ciudad es requerida',
            'display_name.unique' => 'La ciudad ya existe dentro de los registros',
        ];
    }
}

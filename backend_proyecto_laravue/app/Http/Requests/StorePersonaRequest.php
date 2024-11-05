<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombres' => 'required|min:3|max:50',
            'apellidos' => 'required',
            'user_id' => "required"
        ];
    }

    public function messages(): array
    {
        return [
            'nombres.required' => 'la Opcion Nombre completo es Obligatorio',
            'nombres.min' => 'el campo nombre debe ser minimo 3 caracteres',
            'apellidos.required' => 'Apellidos es obligatorio',
        ];
    }

    public function attributes(): array
    {
        return [
            'nombres' => 'Nombre Completo',
        ];
    }
}

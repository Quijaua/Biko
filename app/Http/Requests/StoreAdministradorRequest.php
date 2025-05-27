<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdministradorRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome do administrador é obrigatório.',
            'email.required' => 'O email do administrador é obrigatório.',
            'email.email' => 'O email do administrador deve ser válido.',
            'email.unique' => 'O email do administrador já está em uso.',
        ];
    }
}

<?php

namespace App\Http\Requests;



class UserRequest extends ApiFormRequest
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
            'name' => 'required|string|max:30',
            'dni' => 'required|string|size:10|unique:users,dni'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser una cadena de texto',
            'name.max' => 'El nombre debe tener menos de 30 caracteres',
            'dni.required' => 'El dni es requerido',
            'dni.string' => 'El dni debe ser una cadena de texto',
            'dni.size' => 'El dni debe tener 10 caracteres',
            'dni.unique' => 'El dni ingresado ya está registrado. Por favor, utiliza otro.',
        ];
    }
}

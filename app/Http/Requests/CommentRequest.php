<?php

namespace App\Http\Requests;



class CommentRequest extends ApiFormRequest
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
            'post_id' => 'required|exists:posts,id',
            'user_id' => 'required|exists:users,id',
            'content' => 'required|string',
            'date' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'post_id.required' => 'El post es obligatorio. Por favor, selecciona un post',
            'post_id.exists' => 'El post proporcionado no existe. Asegúrate de que el post esté disponible',
            'user_id.required' => 'El user es obligatorio. Por favor, selecciona un usuario',
            'user_id.exists' => 'El user proporcionado no existe. Asegúrate de que el usuario esté registrado',
            'content.required' => 'El contenido es obligatorio. No puede estar vacío',
            'content.string' => 'El contenido debe ser un texto válido',
            'date.required' => 'La fecha es obligatoria. Por favor, proporciona una fecha válida',
            'date.date' => 'El formato de la fecha no es válido. Asegúrate de usar un formato de fecha correcto',
        ];
    }
}

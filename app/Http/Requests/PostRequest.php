<?php

namespace App\Http\Requests;



class PostRequest extends ApiFormRequest
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
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:150',
            'content' => 'required|string|max:500',
            'published_at' => 'date',
        ];
    }


    public function messages(): array
    {
        return [
            'user_id.required' => 'El usuario es obligatorio',
            'user_id.exists' => 'El usuario seleccionado no está registrado en el sistema',
            'title.required' => 'El título es un campo obligatorio',
            'title.string' => 'El título debe ser un texto válido',
            'title.max' => 'El título no puede exceder los 150 caracteres',
            'content.required' => 'El contenido es un campo obligatorio',
            'content.string' => 'El contenido debe ser un texto válido',
            'content.max' => 'El contenido no puede exceder los 500 caracteres',
            'published_at.date' => 'El formato de la fecha de publicación no es válido',
        ];
    }
}

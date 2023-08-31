<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'document_type' => 'required',
            'document_number' => 'required',
            'name' => 'required',
            'lastname' => 'required',
            'birthdate' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'city_id' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'document_type.*' => 'El Tipo de Documento es requerido.',
            'document_number.required' => 'El Numero de Documento es requerido.',
            'name.required' => 'El Nombre es es requerido.',
            'lastname.required' => 'El Apellido es requerido.',
            'birthdate.required' => 'La Fecha de Nacimiento es requerida.',
            'username.required' => 'El Apodo de usuario es requerido.',
            'email.required' => 'El Correo Eléctronico es requerido.',
            'password.required' => 'La Contraseña es requerida.',
            'city_id.required' => 'La Ciudad de Nacimiento es requerida.',
        ];
    }
}

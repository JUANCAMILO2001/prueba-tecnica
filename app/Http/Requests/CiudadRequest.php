<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CiudadRequest extends FormRequest
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
            'name' => 'required',
            'country' => 'required',
            'population' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'El Nombre es requerido.',
            'country.required' => 'El Pais es requerido.',
            'population.required' => 'La población es requerida.',
        ];
    }
}

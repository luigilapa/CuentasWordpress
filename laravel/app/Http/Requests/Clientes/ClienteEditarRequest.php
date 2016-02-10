<?php

namespace CuentasFacturas\Http\Requests\Clientes;

use CuentasFacturas\Http\Requests\Request;

class ClienteEditarRequest extends Request
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
        $rules = [
            'identificacion' => 'required|numeric',
            'nombres'=> 'required|max:50',
            'apellidos' => 'required|max:50',
            'correo' => 'email|max:255',
            'direccion' => 'max:255',
            'telefono' => 'numeric'
        ];
        return $rules;
    }
}

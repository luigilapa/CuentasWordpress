<?php

namespace CuentasFacturas\Http\Requests\Proveedores;

use CuentasFacturas\Http\Requests\Request;

class ProveedorEditarRequest extends Request
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
            'nombres'=> 'required',
            'correo' => 'email|max:255',
            'direccion' => 'max:255',
            'telefono' => 'numeric'
        ];
        return $rules;
    }
}

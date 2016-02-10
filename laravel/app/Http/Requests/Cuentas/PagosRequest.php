<?php

namespace CuentasFacturas\Http\Requests\Cuentas;

use CuentasFacturas\Http\Requests\Request;

class PagosRequest extends Request
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
            'proveedor_id'=> 'required',
            'abono' => 'required|min:0|regex:/^\d*(\.\d{2})?$/',
            'detalle' => 'max:255',
        ];
        return $rules;
    }
}

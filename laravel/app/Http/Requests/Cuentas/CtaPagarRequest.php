<?php

namespace CuentasFacturas\Http\Requests\Cuentas;

use CuentasFacturas\Http\Requests\Request;

class CtaPagarRequest extends Request
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
            'monto' => 'required|min:0|regex:/^\d*(\.\d{2})?$/',
            'detalle' => 'required|max:255',
            'fecha_max_pago' => 'required|date_format:"Y-m-d"'
        ];
        return $rules;
    }
}

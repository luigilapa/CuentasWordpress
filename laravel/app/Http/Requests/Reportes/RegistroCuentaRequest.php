<?php

namespace CuentasFacturas\Http\Requests\Reportes;

use CuentasFacturas\Http\Requests\Request;

class RegistroCuentaRequest extends Request
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
            'fecha_inicio' => 'date_format:"Y-m-d"',
            'fecha_fin' => 'date_format:"Y-m-d"',
            'identificacion' => 'required|numeric',
        ];
        return $rules;
    }
}

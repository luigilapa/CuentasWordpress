<?php

namespace CuentasFacturas;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CuentasxpagarModel extends Model
{
    use SoftDeletes;

    protected $table = 'cuentasxpagar';

    protected $fillable = ['id', 'proveedor_id', 'monto', 'detalle', 'fecha_max_pago', 'saldo'];
    protected $hidden = ['id'];
}

<?php

namespace CuentasFacturas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CobrosModel extends Model
{
    use SoftDeletes;

    protected $table = 'cobros';

    protected $fillable = ['cuentaxcobrar_id', 'abono', 'fecha_cobro', 'detalle'];
}

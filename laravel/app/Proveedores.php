<?php

namespace CuentasFacturas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedores extends Model
{
    use SoftDeletes;

    protected $table = 'proveedores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','identificacion', 'nombres', 'correo', 'telefono', 'direccion'];
}

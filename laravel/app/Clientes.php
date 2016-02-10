<?php

namespace CuentasFacturas;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clientes extends Model
{
    use SoftDeletes;

    protected $table = 'clientes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','identificacion', 'nombres', 'apellidos', 'correo', 'telefono', 'direccion'];

    //protected $hidden = ['id'];
}

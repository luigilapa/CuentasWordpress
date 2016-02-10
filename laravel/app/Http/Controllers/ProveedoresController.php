<?php

namespace CuentasFacturas\Http\Controllers;

use CuentasFacturas\Http\Extenciones\Validaciones;
use CuentasFacturas\Proveedores;
use Illuminate\Http\Request;

use CuentasFacturas\Http\Requests;
use CuentasFacturas\Http\Controllers\Controller;

class ProveedoresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getList()
    {
        $proveedores = Proveedores::orderBy('nombres')->paginate(10);

        return view('proveedores.lista', compact('proveedores'));
    }

    public function getRegistro()
    {
        return view('proveedores.registrar');
    }
    public function postRegistro(Requests\Proveedores\ProveedorRegistroRequest $request)
    {
        $resp = Validaciones::validarCI($request['identificacion']);
        if ($resp != 'ok') {
            $errors = array("0" => $resp);
            return $request->response($errors);
        }

        Proveedores::create($request->all());
        return redirect()->route('registrar_proveedor')->with('message', 'ok');
    }

    public function getEditar($id)
    {
        if($id == 0)
        {
            return \Response::view('errors.500');
        }
        $proveedor = Proveedores::find($id);
        return view('proveedores.editar',compact('proveedor'));
    }

    public function posteditar(Requests\Proveedores\ProveedorEditarRequest $request)
    {
        $proveedor = Proveedores::find($request['id']);

        $resp = Validaciones::validarCI($request['identificacion']);
        if ($resp != 'ok') {
            $errors = array("0" => $resp);
            return $request->response($errors);
        }

        $existe = Proveedores::where('identificacion','=',$request['identificacion'])->where('id','<>',$request['id'])->get();
        if($existe->count() > 0){
            $errors = array(
                "0" => "Identificación ya existe!"
            );
            return $request->response($errors);
        }

        $proveedor->fill($request->all());
        $proveedor->save();
        return redirect()->route('lista_proveedores')->with('message', 'editok');
    }

    public  function getAnular($id)
    {
        $proveedor = Proveedores::find($id);
        $proveedor->delete();
        return response()->json([
            "mensaje" => 'ok',
        ]);
        //return redirect()->route('lista_clientes')->with('message', 'anularok');
    }

    public  function  getAnulados()
    {
        $proveedores = Proveedores::onlyTrashed()->orderBy('nombres')->paginate(10);
        return view('proveedores.anulados',compact('proveedores'));
    }

    public function getRestaurar($id)
    {
        $proveedor = Proveedores::withTrashed()->find($id);
        $proveedor->restore();
        return response()->json([
            "mensaje" => 'ok',
        ]);
    }

    public function getEliminar($id)
    {
        $proveedor = Proveedores::withTrashed()->find($id);
        $proveedor->forceDelete();
        return response()->json([
            "mensaje" => 'ok',
        ]);
    }
}

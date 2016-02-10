<?php

namespace CuentasFacturas\Http\Controllers;

use CuentasFacturas\CuentasxpagarModel;
use CuentasFacturas\PagosModel;
use CuentasFacturas\Proveedores;
use Illuminate\Http\Request;

use CuentasFacturas\Http\Requests;
use CuentasFacturas\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CuentasPagarController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function getRegistro()
    {
        return view('cuentasxpagar.registro');
    }

    public function postRegistro(Requests\Cuentas\CtaPagarRequest $request)
    {
        //CuentasxcobrarModel::create($request->all());
        $this->GuardarFactura($request->all());
        return redirect()->route('registrar_ctaxpagar')->with('message', 'ok');
    }

    public function getBuscarProveedor($identificacion)
    {
        $identificacion = str_replace(' ', '', $identificacion);

        $proveedores = Proveedores::where('identificacion','=',$identificacion)->first();
        if($proveedores != null) {
            return response()->json($proveedores->toArray());
        }
    }

    public function getConsulta()
    {
        $ctasxpagar = CuentasxpagarModel::where("estado_activo","=",1)
            ->join('proveedores', 'proveedores.id', '=', 'cuentasxpagar.proveedor_id')
            ->groupBy('proveedor_id')
            ->select(DB::raw('count(*) as contador, proveedores.identificacion, proveedores.nombres, Sum(saldo) as monto, proveedor_id'))
            ->orderby('proveedores.nombres')
            ->paginate(10);
        return view('cuentasxpagar.consulta',compact('ctasxpagar'));
    }

    public function getConsultaDetalles($proveedor_id)
    {
        $facturas = CuentasxpagarModel::where('proveedor_id','=',$proveedor_id)
            ->where("estado_activo","=",1)
            ->join('proveedores', 'proveedores.id', '=', 'cuentasxpagar.proveedor_id')
            ->select(DB::raw('proveedores.identificacion, proveedores.nombres, cuentasxpagar.id, cuentasxpagar.monto, cuentasxpagar.detalle, cuentasxpagar.fecha_max_pago, cuentasxpagar.created_at, cuentasxpagar.estado_activo, cuentasxpagar.saldo, cuentasxpagar.proveedor_id'))
            ->paginate(10);

        if($facturas->count() == 0)
        {
            return  redirect()->route('consulta_ctaxpagar')->with('message', 'error_consulta');
        }

        return view('cuentasxpagar.consulta_detalles',compact('facturas'));
    }

    public function getAbonos()
    {
        return view('cuentasxpagar.abono');
    }

    public function postAbonos(Requests\Cuentas\PagosRequest $request)
    {
        $this->RegistrarAbono($request);
        return redirect()->route('consulta_ctaxpagar')->with('message', 'ok');
    }

    public function getAbonosAjax($identificacion)
    {
        $proveedor = Proveedores::where('identificacion','=',$identificacion)->first();

        $datos = CuentasxpagarModel::where('proveedor_id','=',$proveedor->id)
            ->where("estado_activo","=",1)
            ->join('proveedores', 'proveedores.id', '=', 'cuentasxpagar.proveedor_id')
            ->groupBy('proveedor_id')
            ->select(DB::raw('count(*) as contador, proveedores.identificacion, proveedores.nombres, Sum(saldo) as monto, proveedor_id'))
            ->orderby('proveedores.nombres')
            ->get();

        if($datos != null) {
            return response()->json($datos);
        }
    }

    public function getAbonosDatos($id)
    {
        $datos = CuentasxpagarModel::where('proveedor_id','=',$id)
            ->where("estado_activo","=",1)
            ->join('proveedores', 'proveedores.id', '=', 'cuentasxpagar.proveedor_id')
            ->groupBy('proveedor_id')
            ->select(DB::raw('count(*) as contador, proveedores.identificacion, proveedores.nombres, Sum(saldo) as monto, proveedor_id'))
            ->orderby('proveedores.nombres')
            ->get();
        return view('cuentasxpagar.abono_datos',compact('datos'));
    }

    public function postAbonosDatos(Requests\Cuentas\PagosRequest $request)
    {
        $abono = $request['abono'];
        $cuentasxpagar = CuentasxpagarModel::where('proveedor_id','=',$request['proveedor_id'])
            ->where("estado_activo","=",1)
            ->orderBy('created_at')
            ->get();

        if($abono > $cuentasxpagar->sum('saldo')) {
            $errors = array("0" => "El valor del pago es mayor a la deuda pendiente!");
            return $request->response($errors);
        }
        $this->RegistrarAbono($request, $cuentasxpagar);
        return  redirect()->route('consulta_ctaxpagar')->with('message', 'ok');
    }

    //*** metodos
    protected function GuardarPago(array $data)
    {
        return PagosModel::create([
            'cuentaxpagar_id' => $data['cuentaxpagar_id'],
            'abono' => $data['abono'],
            'detalle' => $data['detalle'],
            'fecha_pago' => $data['fecha_pago']
        ]);
    }
    protected function GuardarFactura(array $data){
        return CuentasxpagarModel::create([
            'proveedor_id' => $data['proveedor_id'],
            'monto' => $data['monto'],
            'detalle' => $data['detalle'],
            'fecha_max_pago' => $data['fecha_max_pago'],
            'saldo' => $data['monto'],
        ]);
    }
    protected  function RegistrarAbono($request, $cuentasxpagar)
    {
        $abono = $request['abono'];

        foreach($cuentasxpagar as $item)
        {
            if($abono >= $item->saldo){
                $item->estado_activo = false;
                $abono = $abono - $item->saldo;
                $item->saldo = 0;

                $registro = array(
                    'cuentaxpagar_id' => $item->id,
                    'abono'=> $item->monto,
                    'detalle' => $request['detalle'],
                    'fecha_pago' => date('Y-m-d H:i:s')
                );
                $this->GuardarPago($registro);
                $item->Save();
            }
            else if ($abono < $item->saldo){
                $item->saldo = $item->saldo - $abono;

                $registro = array(
                    'cuentaxpagar_id' => $item->id,
                    'abono'=> $abono,
                    'detalle' => $request['detalle'],
                    'fecha_pago' => date('Y-m-d H:i:s')
                );
                $this->GuardarPago($registro);
                $item->Save();

                $abono = 0;
            }
            if($abono == 0){
                return;
            }
        }
    }
}

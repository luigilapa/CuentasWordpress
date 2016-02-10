<?php

namespace CuentasFacturas\Http\Controllers;

use CuentasFacturas\Clientes;
use CuentasFacturas\CobrosModel;
use CuentasFacturas\CuentasxcobrarModel;
use Illuminate\Http\Request;

use CuentasFacturas\Http\Requests;
use CuentasFacturas\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CuentasCobrarController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getRegistro()
    {
        return view('cuentasxcobrar.registro');
    }

    public function postRegistro(Requests\Cuentas\CtaCobrarRequest $request)
    {
        //CuentasxcobrarModel::create($request->all());
        $this->GuardarFactura($request->all());
        return redirect()->route('registrar_ctaxcobrar')->with('message', 'ok');
    }

    public function getBuscarCliente($identificacion)
    {
        $identificacion = str_replace(' ', '', $identificacion);

        $cliente = Clientes::where('identificacion','=',$identificacion)->first();
        if($cliente != null) {
            return response()->json($cliente->toArray());
        }
    }

    public function getConsulta()
    {
        $ctasxcobrar = CuentasxcobrarModel::where("estado_activo","=",1)
                                            ->join('clientes', 'clientes.id', '=', 'cuentasxcobrar.cliente_id')
                                            ->groupBy('cliente_id')
                                            ->select(DB::raw('count(*) as contador, clientes.identificacion, clientes.nombres, clientes.apellidos, Sum(saldo) as monto, cliente_id'))
                                            ->orderby('clientes.nombres')->orderby('clientes.apellidos')
                                            ->paginate(10);
        return view('cuentasxcobrar.consulta',compact('ctasxcobrar'));
    }

    public function getConsultaDetalles($cliente_id)
    {
        $facturas = CuentasxcobrarModel::where('cliente_id','=',$cliente_id)
                                        ->where("estado_activo","=",1)
                                        ->join('clientes', 'clientes.id', '=', 'cuentasxcobrar.cliente_id')
                                        ->select(DB::raw('clientes.identificacion, clientes.nombres, clientes.apellidos, cuentasxcobrar.id, cuentasxcobrar.monto, cuentasxcobrar.detalle, cuentasxcobrar.fecha_max_pago, cuentasxcobrar.created_at, cuentasxcobrar.estado_activo, cuentasxcobrar.saldo, cuentasxcobrar.cliente_id'))
                                        ->paginate(10);

        if($facturas->count() == 0)
        {
            return  redirect()->route('consulta_ctaxcobrar')->with('message', 'error_consulta');
        }

        return view('cuentasxcobrar.consulta_detalles',compact('facturas'));
    }

    public function getAbonos()
    {
        return view('cuentasxcobrar.abono');
    }

    public function postAbonos(Requests\Cuentas\CobrosRequest $request)
    {
        $this->RegistrarAbono($request);
        return redirect()->route('consulta_ctaxcobrar')->with('message', 'ok');
    }

    public function getAbonosAjax($identificacion)
    {
        $cliente = Clientes::where('identificacion','=',$identificacion)->first();

        $datos = CuentasxcobrarModel::where('cliente_id','=',$cliente->id)
                                    ->where("estado_activo","=",1)
                                    ->join('clientes', 'clientes.id', '=', 'cuentasxcobrar.cliente_id')
                                    ->groupBy('cliente_id')
                                    ->select(DB::raw('count(*) as contador, clientes.identificacion, clientes.nombres, clientes.apellidos, Sum(saldo) as monto, cliente_id'))
                                    ->orderby('clientes.nombres')->orderby('clientes.apellidos')
                                    ->get();

        if($datos != null) {
            return response()->json($datos);
        }
    }

    public function getAbonosDatos($id)
    {
        $datos = CuentasxcobrarModel::where('cliente_id','=',$id)
            ->where("estado_activo","=",1)
            ->join('clientes', 'clientes.id', '=', 'cuentasxcobrar.cliente_id')
            ->groupBy('cliente_id')
            ->select(DB::raw('count(*) as contador, clientes.identificacion, clientes.nombres, clientes.apellidos, Sum(saldo) as monto, cliente_id'))
            ->orderby('clientes.nombres')->orderby('clientes.apellidos')
            ->get();
        return view('cuentasxcobrar.abono_datos',compact('datos'));
    }

    public function postAbonosDatos(Requests\Cuentas\CobrosRequest $request)
    {
        $cuentasxcobrar = CuentasxcobrarModel::where('cliente_id','=',$request['cliente_id'])
            ->where("estado_activo","=",1)
            ->orderBy('created_at')
            ->get();

        $abono = $request['abono'];
        if($abono > $cuentasxcobrar->sum('saldo')) {
            $errors = array("0" => "El valor del pago es mayor a la deuda pendiente!");
            return $request->response($errors);
        }

        $this->RegistrarAbono($request, $cuentasxcobrar);
        return  redirect()->route('consulta_ctaxcobrar')->with('message', 'ok');
    }

    //*** metodos
    protected function GuardarPago(array $data)
    {
        return CobrosModel::create([
            'cuentaxcobrar_id' => $data['cuentaxcobrar_id'],
            'abono' => $data['abono'],
            'detalle' => $data['detalle'],
            'fecha_cobro' => $data['fecha_cobro']
        ]);
    }
    protected function GuardarFactura(array $data){
        return CuentasxcobrarModel::create([
            'cliente_id' => $data['cliente_id'],
            'monto' => $data['monto'],
            'detalle' => $data['detalle'],
            'fecha_max_pago' => $data['fecha_max_pago'],
            'saldo' => $data['monto'],
        ]);
    }
    protected  function RegistrarAbono($request, $cuentasxcobrar)
    {
        $abono = $request['abono'];

        foreach($cuentasxcobrar as $item)
        {
            if($abono >= $item->saldo){
                $item->estado_activo = false;
                $abono = $abono - $item->saldo;
                $item->saldo = 0;

                $registro = array(
                    'cuentaxcobrar_id' => $item->id,
                    'abono'=> $item->monto,
                    'detalle' => $request['detalle'],
                    'fecha_cobro' => date('Y-m-d H:i:s')
                );
                $this->GuardarPago($registro);
                $item->Save();
            }
            else if ($abono < $item->saldo){
                $item->saldo = $item->saldo - $abono;

                $registro = array(
                    'cuentaxcobrar_id' => $item->id,
                    'abono'=> $abono,
                    'detalle' => $request['detalle'],
                    'fecha_cobro' => date('Y-m-d H:i:s')
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

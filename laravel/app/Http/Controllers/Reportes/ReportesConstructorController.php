<?php

namespace CuentasFacturas\Http\Controllers\Reportes;

use CuentasFacturas\Clientes;
use CuentasFacturas\CobrosModel;
use CuentasFacturas\CuentasxcobrarModel;
use CuentasFacturas\CuentasxpagarModel;
use CuentasFacturas\PagosModel;
use CuentasFacturas\Proveedores;
use Illuminate\Http\Request;

use CuentasFacturas\Http\Requests;
use CuentasFacturas\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReportesConstructorController extends Controller
{
   function getRegistroCuenta()
   {
       return view('reportes.registro_cuenta');
   }

    function postRegistroCuenta(Requests\Reportes\RegistroCuentaRequest $request)
    {
        $identificacion = "";
        $nombres = "";
        $tipo = "";

        if($request['tipo'] == 'ctaxcobrar')
        {
            $cliente = Clientes::where('identificacion','=',$request['identificacion'])->first();
            $lista = CuentasxcobrarModel::where('cliente_id','=',$cliente->id);
            $identificacion = $cliente->identificacion;
            $nombres = $cliente->nombres.' '.$cliente->apellidos;
            $tipo = "Cliente:";
        }
        else if ($request['tipo'] == 'ctaxpagar')
        {
            $proveedor = Proveedores::where('identificacion','=',$request['identificacion'])->first();
            $lista = CuentasxpagarModel::where('proveedor_id','=',$proveedor->id);
            $identificacion = $proveedor->identificacion;
            $nombres = $proveedor->nombres;
            $tipo = "Proveedor:";
        }

        if ($request['fecha_inicio'] != "" && $request['fecha_fin'] != "")
        {
            $lista = $lista->where('created_at','>=',$request['fecha_inicio'])
                            ->where('created_at','<=',$request['fecha_fin']);
        }

        if($request['pendiente'] == 1){
            $lista = $lista->where('estado_activo','=',1);
        }

        $lista = $lista->get();
        $reporte = new Reporte("Registro de pagos");

        $filas = "";
        if($lista->count() == 0)
        {
            $html = '<div style="text-align:center"><p>Sin datos para mostrar</p></div>';
        }
        else {
            $cont = 0;
            $html = "";
            foreach ($lista as $item) {
                $cont++;
                $mod = $cont % 2 == 0;
                $estado = $item->estado_activo == 1 ? "Pendiente" : "Pagado";
                if ($mod == 1) {
                    $filas = '<tr>' .
                        '<td style="background: #E8EDFF; color: #1E252B; font-size: 12px; text-align: center;">' . $item->created_at . '</td>' .
                        '<td style="background: #E8EDFF; color: #1E252B; font-size: 12px; text-align: center;">' . $item->detalle . '</td>' .
                        '<td style="background: #E8EDFF; color: #1E252B; font-size: 12px; text-align: center;">' . $item->monto . '</td>' .
                        '<td style="background: #E8EDFF; color: #1E252B; font-size: 12px; text-align: center;">' . $item->saldo . '</td>' .
                        '<td style="background: #E8EDFF; color: #1E252B; font-size: 12px; text-align: center;">' . $item->fecha_max_pago . '</td>' .
                        '<td style="background: #E8EDFF; color: #1E252B; font-size: 12px; text-align: center;">' . $estado . '</td>' .
                        '</tr>';
                } else {
                    $filas = '<tr>' .
                        '<td style="background: #F5F5F5; color: #1E252B; font-size: 12px; text-align: center;">' . $item->created_at . '</td>' .
                        '<td style="background: #F5F5F5; color: #1E252B; font-size: 12px; text-align: center;">' . $item->detalle . '</td>' .
                        '<td style="background: #F5F5F5; color: #1E252B; font-size: 12px; text-align: center;">' . $item->monto . '</td>' .
                        '<td style="background: #F5F5F5; color: #1E252B; font-size: 12px; text-align: center;">' . $item->saldo . '</td>' .
                        '<td style="background: #F5F5F5; color: #1E252B; font-size: 12px; text-align: center;">' . $item->fecha_max_pago . '</td>' .
                        '<td style="background: #F5F5F5; color: #1E252B; font-size: 12px; text-align: center;">' . $estado . '</td>' .
                        '</tr>';
                }

                $cont2 = 0;
                $sublista = $this->RegistroPagos($request['tipo'], $item->id);
                $filas2 = "";
                if ($sublista->count() > 0) {
                    foreach ($sublista as $item) {
                        $cont2++;
                        $mod = $cont2 % 2 == 0;

                        if ($mod == 1) {
                            $filas2 .= '<tr>' .
                                '<td style="background: #ffebcc; color: #1E252B; font-size: 12px; text-align: center;">' . $item->created_at . '</td>' .
                                '<td style="background: #ffebcc; color: #1E252B; font-size: 12px; text-align: center;">' . $item->detalle . '</td>' .
                                '<td style="background: #ffebcc; color: #1E252B; font-size: 12px; text-align: center;">' . $item->abono . '</td>' .
                                '</tr>';
                        } else {
                            $filas2 .= '<tr>' .
                                '<td style="background: #FFFFFF; color: #1E252B; font-size: 12px; text-align: center;">' . $item->created_at . '</td>' .
                                '<td style="background: #FFFFFF; color: #1E252B; font-size: 12px; text-align: center;">' . $item->detalle . '</td>' .
                                '<td style="background: #FFFFFF; color: #1E252B; font-size: 12px; text-align: center;">' . $item->abono . '</td>' .
                                '</tr>';
                        }
                    }
                }
                $columnas = array('Fecha registro', 'Detalle', 'Monto', 'Saldo', 'Fecha Max. Pago', 'Estado');
                $columnas2 = array('Fecha pago', 'Detalle', 'abono');
                $html .= '<br/>' . $reporte->getTable($columnas, $filas).'<br/>'.$reporte->getSubTable($columnas2, $filas2);
            }
        }

        $datos = '<div>'.
            '<b style="color: #2355AE;">Identificaci&#243;n:</b><label>'.$identificacion.'</label>'.
            '<br/>'.
            '<b style="color: #2355AE;">'.$tipo.' </b><label>'.$nombres.'</label>'.
            '</div>';

        $mpdf=new \mPDF('utf-8','A4','','','15','15','28','18');
        $mpdf->SetTitle("Reporte");
        $mpdf->SetHTMLHeader($reporte->getHeader());
        $mpdf->SetHTMLFooter($reporte->getFooter());
        $mpdf->WriteHTML($datos.$html);
        $mpdf->Output('reporte.pdf','I');
    }

    function RegistroPagos($tipo, $idcuenta)
    {
        if($tipo = "ctaxcobrar"){
            $lista = CobrosModel::where('cuentaxcobrar_id','=',$idcuenta)->get();
        }
        else{
            $lista = PagosModel::where('cuentaxpagar_id','=',$idcuenta)->get();
        }
        return $lista;
    }
}

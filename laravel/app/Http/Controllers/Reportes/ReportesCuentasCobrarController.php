<?php

namespace CuentasFacturas\Http\Controllers\Reportes;

use CuentasFacturas\CuentasxcobrarModel;
use Illuminate\Http\Request;

use CuentasFacturas\Http\Requests;
use CuentasFacturas\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReportesCuentasCobrarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getCuentasClientes($cliente_id)
    {
        $facturas = CuentasxcobrarModel::where('cliente_id','=',$cliente_id)
            ->where("estado_activo","=",1)
            ->join('clientes', 'clientes.id', '=', 'cuentasxcobrar.cliente_id')
            ->select(DB::raw('clientes.identificacion, clientes.nombres, clientes.apellidos, cuentasxcobrar.id, cuentasxcobrar.monto, cuentasxcobrar.detalle, cuentasxcobrar.fecha_max_pago, cuentasxcobrar.created_at, cuentasxcobrar.estado_activo, cuentasxcobrar.saldo, cuentasxcobrar.cliente_id'))
            ->get();

        $reporte = new Reporte("Cuentas por cobrar al cliente");

        $filas = "";
        if($facturas->count() == 0)
        {
            $tabla = '<div style="text-align:center"><p>Sin datos para mostrar</p></div>';
        }
        else {
            $cont = 0;
            foreach ($facturas as $item) {
                $cont++;
                $mod = $cont % 2 == 0;
                $estado = $item->estado_activo==1? "Pendiente": "Pagado";
                if ($mod == 1) {
                    $filas .= '<tr>' .
                        '<td style="background: #E8EDFF; color: #1E252B; font-size: 12px; text-align: center;">' . $item->created_at . '</td>' .
                        '<td style="background: #E8EDFF; color: #1E252B; font-size: 12px; text-align: center;">' . $item->detalle . '</td>' .
                        '<td style="background: #E8EDFF; color: #1E252B; font-size: 12px; text-align: center;">' . $item->monto . '</td>' .
                        '<td style="background: #E8EDFF; color: #1E252B; font-size: 12px; text-align: center;">' . $item->saldo . '</td>' .
                        '<td style="background: #E8EDFF; color: #1E252B; font-size: 12px; text-align: center;">' . $item->fecha_max_pago . '</td>' .
                        '<td style="background: #E8EDFF; color: #1E252B; font-size: 12px; text-align: center;">' . $estado . '</td>' .
                        '</tr>';
                } else {
                    $filas .= '<tr>' .
                        '<td style="background: #F5F5F5; color: #1E252B; font-size: 12px; text-align: center;">' . $item->created_at . '</td>' .
                        '<td style="background: #F5F5F5; color: #1E252B; font-size: 12px; text-align: center;">' . $item->detalle . '</td>' .
                        '<td style="background: #F5F5F5; color: #1E252B; font-size: 12px; text-align: center;">' . $item->monto . '</td>' .
                        '<td style="background: #F5F5F5; color: #1E252B; font-size: 12px; text-align: center;">' . $item->saldo . '</td>' .
                        '<td style="background: #F5F5F5; color: #1E252B; font-size: 12px; text-align: center;">' . $item->fecha_max_pago . '</td>' .
                        '<td style="background: #F5F5F5; color: #1E252B; font-size: 12px; text-align: center;">' . $estado . '</td>' .
                        '</tr>';
                }
            }

            $columnas = array('Fecha registro','Detalle','Monto','Saldo','Fecha Max. Pago','Estado');
            $tabla = $reporte->getTable($columnas,$filas);

            $datos = '<div>'.
                        '<b style="color: #2355AE;">Identificaci&#243;n:</b><label>'.$facturas[0]->identificacion.'</label>'.
                        '<br/>'.
                        '<b style="color: #2355AE;">Cliente: </b><label>'.$facturas[0]->nombres.' '.$facturas[0]->apellidos.'</label>'.
                    '</div>';
        }

        $mpdf=new \mPDF('utf-8','A4','','','15','15','28','18');
        $mpdf->SetTitle("Reporte");
        $mpdf->SetHTMLHeader($reporte->getHeader());
        $mpdf->SetHTMLFooter($reporte->getFooter());
        $mpdf->WriteHTML($datos.$tabla);
        $mpdf->Output('reporte.pdf','I');
    }

    public function getCuentas()
    {
        $facturas = CuentasxcobrarModel::where("estado_activo","=",1)
                ->join('clientes', 'clientes.id', '=', 'cuentasxcobrar.cliente_id')
                ->groupBy('cliente_id')
                ->select(DB::raw('count(*) as contador, clientes.identificacion, clientes.nombres, clientes.apellidos, Sum(saldo) as monto, cliente_id'))
                ->orderby('clientes.nombres')->orderby('clientes.apellidos')
                ->get();

        $reporte = new Reporte("Cuentas por cobrar");

        $filas = "";
        if($facturas->count() == 0)
        {
            $tabla = '<div style="text-align:center"><p>Sin datos para mostrar</p></div>';
        }
        else {
            $cont = 0;
            foreach ($facturas as $item) {
                $cont++;
                $mod = $cont % 2 == 0;
                if ($mod == 1) {
                    $filas .= '<tr>' .
                        '<td style="background: #E8EDFF; color: #1E252B; font-size: 12px; text-align: center;">' . $item->identificacion . '</td>' .
                        '<td style="background: #E8EDFF; color: #1E252B; font-size: 12px; text-align: center;">' . $item->nombres .' '.$item->apellidos. '</td>' .
                        '<td style="background: #E8EDFF; color: #1E252B; font-size: 12px; text-align: center;">' . $item->contador . '</td>' .
                        '<td style="background: #E8EDFF; color: #1E252B; font-size: 12px; text-align: center;">' . $item->monto . '</td>' .
                        '</tr>';
                } else {
                    $filas .= '<tr>' .
                        '<td style="background: #F5F5F5; color: #1E252B; font-size: 12px; text-align: center;">' . $item->identificacion . '</td>' .
                        '<td style="background: #F5F5F5; color: #1E252B; font-size: 12px; text-align: center;">' . $item->nombres .' '.$item->apellidos. '</td>' .
                        '<td style="background: #F5F5F5; color: #1E252B; font-size: 12px; text-align: center;">' . $item->contador . '</td>' .
                        '<td style="background: #F5F5F5; color: #1E252B; font-size: 12px; text-align: center;">' . $item->monto . '</td>' .
                        '</tr>';
                }
            }

            $columnas = array('Identificaci&#243;n','Cliente','Facturas','Total');
            $tabla = $reporte->getTable($columnas,$filas);

        }

        $mpdf=new \mPDF('utf-8','A4','','','15','15','28','18');
        $mpdf->SetTitle("Reporte");
        $mpdf->SetHTMLHeader($reporte->getHeader());
        $mpdf->SetHTMLFooter($reporte->getFooter());
        $mpdf->WriteHTML($tabla);
        $mpdf->Output('reporte.pdf','I');
    }
}

<?php

namespace CuentasFacturas\Http\Controllers\Reportes;

use CuentasFacturas\Proveedores;
use Illuminate\Http\Request;

use CuentasFacturas\Http\Requests;
use CuentasFacturas\Http\Controllers\Controller;

class ReportesProvedoresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function getProveedores()
    {
        $proveedores = Proveedores::orderBy('nombres')->get();

        $reporte = new Reporte("Lista de proveedores");

        $filas = "";
        if ($proveedores->count() == 0) {
            $tabla = '<div style="text-align:center"><p>Sin datos para mostrar</p></div>';
        } else {
            $cont = 0;
            foreach ($proveedores as $item) {
                $cont++;
                $mod = $cont % 2 == 0;
                if ($mod == 1) {
                    $filas .= '<tr>' .
                        '<td style="background: #E8EDFF; color: #1E252B; font-size: 12px; text-align: center;">' . $item->identificacion . '</td>' .
                        '<td style="background: #E8EDFF; color: #1E252B; font-size: 12px; text-align: left;">' . $item->nombres . '</td>' .
                        '<td style="background: #E8EDFF; color: #1E252B; font-size: 12px; text-align: left;">' . $item->correo . '</td>' .
                        '<td style="background: #E8EDFF; color: #1E252B; font-size: 12px; text-align: left;">' . $item->direccion . '</td>' .
                        '<td style="background: #E8EDFF; color: #1E252B; font-size: 12px; text-align: center;">' . $item->telefono . '</td>' .
                        '</tr>';
                } else {
                    $filas .= '<tr>' .
                        '<td style="background: #F5F5F5; color: #1E252B; font-size: 12px; text-align: center;">' . $item->identificacion . '</td>' .
                        '<td style="background: #F5F5F5; color: #1E252B; font-size: 12px; text-align: left;">' . $item->nombres . '</td>' .
                        '<td style="background: #F5F5F5; color: #1E252B; font-size: 12px; text-align: left;">' . $item->correo . '</td>' .
                        '<td style="background: #F5F5F5; color: #1E252B; font-size: 12px; text-align: left;">' . $item->direccion . '</td>' .
                        '<td style="background: #F5F5F5; color: #1E252B; font-size: 12px; text-align: center;">' . $item->telefono . '</td>' .
                        '</tr>';
                }
            }

            $columnas = array('Identificaci&#243;n', 'Nombres', 'Correo', 'Direcci&#243;n', 'Tel&#233;fono');
            $tabla = $reporte->getTable($columnas, $filas);

        }

        $mpdf=new \mPDF('utf-8','A4-L','','','15','15','28','18');
        $mpdf->SetTitle("Reporte");
        $mpdf->SetHTMLHeader($reporte->getHeader());
        $mpdf->SetHTMLFooter($reporte->getFooter());
        $mpdf->WriteHTML($tabla);
        $mpdf->Output('reporte.pdf', 'I');
    }
}

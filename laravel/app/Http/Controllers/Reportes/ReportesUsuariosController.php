<?php

namespace CuentasFacturas\Http\Controllers\Reportes;

use CuentasFacturas\User;
use Illuminate\Http\Request;

use CuentasFacturas\Http\Requests;
use CuentasFacturas\Http\Controllers\Controller;

class ReportesUsuariosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   function getUsuarios()
   {
       $usuarios = User::orderBy('type')->orderBy('name')->get();

       $reporte = new Reporte("Lista de usuarios");

       $filas = "";
       if($usuarios->count() == 0)
       {
           $tabla = '<div style="text-align:center"><p>Sin datos para mostrar</p></div>';
       }
       else {
           $cont = 0;
           foreach ($usuarios as $item) {
               $cont++;
               $mod = $cont % 2 == 0;
               if ($mod == 1) {
                   $filas .= '<tr>' .
                       '<td style="background: #E8EDFF; color: #1E252B; font-size: 12px; text-align: left;">' . $item->name . '</td>' .
                       '<td style="background: #E8EDFF; color: #1E252B; font-size: 12px; text-align: center;">' . $item->username .'</td>' .
                       '<td style="background: #E8EDFF; color: #1E252B; font-size: 12px; text-align: left;">' . $item->email . '</td>' .
                       '<td style="background: #E8EDFF; color: #1E252B; font-size: 12px; text-align: center;">' . $item->type . '</td>' .
                       '</tr>';
               } else {
                   $filas .= '<tr>' .
                       '<td style="background: #F5F5F5; color: #1E252B; font-size: 12px; text-align: left;">' . $item->name . '</td>' .
                       '<td style="background: #F5F5F5; color: #1E252B; font-size: 12px; text-align: center;">' . $item->username . '</td>' .
                       '<td style="background: #F5F5F5; color: #1E252B; font-size: 12px; text-align: left;">' . $item->email . '</td>' .
                       '<td style="background: #F5F5F5; color: #1E252B; font-size: 12px; text-align: center;">' . $item->type . '</td>' .
                       '</tr>';
               }
           }

           $columnas = array('Nombres','Usuario','Correo', 'Tipo');
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

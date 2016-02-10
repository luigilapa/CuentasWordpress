<?php
namespace CuentasFacturas\Http\Controllers\Reportes;


class Reporte
{
    private  $header;
    private $footer;
    private $table;

    /**
     * Reporte constructor.
     */
    public function __construct($titulo)
    {
        $this->header = '<header>'.
                            '<div>'.
                                '<h1 style="color:#2254AD; font-size:16px; text-align:left;">Cuentas por pagar & Cuentas por cobrar</h1>'.
                                '<h2 style="color:#1E252B; font-size:12px; text-align:left;">'.$titulo.'</h2>'.
                            '</div>'.
                            '<div style="position:absolute; width: 55px; margin-top:-65px; margin-left:600px;">'.
                            '   <img src="assets/image/logo.png" alt="" style="width: 50px; height: 50px;">'.
                            '</div>'.
                        '</header>'.
                        '<hr/>';

        $this->footer = '<footer>'.
                        '<hr/>'.
                        '<div style="text-align:right;"><p>{PAGENO}</p></div>'.
                        '</footer>';
    }

    public function getHeader() {
        return $this->header;
    }

    public function getFooter() {
        return $this->footer;
    }

    public function getTable($columnas, $filas) {

        $col ="";
        foreach($columnas as $columna)
        {
            $col .= '<th style="background: #D0DAFD; color: #2355AE; font-size: 14px;">'.$columna.'</th>';
        }

        $this->table = '<div>' .
            '<table style="width:100%;">' .
            '<thead style="">' .
            '<tr>' .
            $col.
            '</tr>' .
            '</thead>' .
            '<tbody style="">' .
            $filas .
            '</tbody>' .
            '</table>' .
            '</div>';

        return $this->table;
    }

    public function getSubTable($columnas, $filas) {

        if($filas == "")
        {
            return '<div style="width:75%;" style="text-align:right"><p>No se han realizado pagos...</p></div>';
        }

        $col ="";
        foreach($columnas as $columna)
        {
            $col .= '<th style="background: #ffbf00; color: #000000; font-size: 14px;">'.$columna.'</th>';
        }

        $this->table = '<div>' .
            '<table style="width:75%;" align="right">' .
            '<thead style="">' .
            '<tr>' .
            $col.
            '</tr>' .
            '</thead>' .
            '<tbody style="">' .
            $filas .
            '</tbody>' .
            '</table>' .
            '</div>';

        return $this->table;
    }
}
@extends('layout/master')
<?php $title='Generar Reporte' ?>

@section('content')
    @include('alerts.request')
    {!! Form::open(['route' => 'registro_cuenta', 'class' => 'form', 'target'=>'_blank']) !!}
    <div class="row">
        <div class="form-group col-sm-6 col-md-6 col-lg-3">
            <label>Tipo</label>
            {!! Form::select('tipo', array('ctaxcobrar' => 'Cuentas Por Cobrar', 'ctaxpagar' => 'Cuentas Por Pagar'), 'ctaxcobrar' , ['class'=> 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-4 col-md-2 col-lg-2">
            {!! Form::label('fecha_inicio','Fecha Inicio') !!}
            {!! Form::date('fecha_inicio', '', ['class'=> 'form-control', 'ReadOnly'=>'true']) !!}
        </div>
        <div class="form-group col-sm-4 col-md-2 col-lg-2">
            {!! Form::label('fecha_fin','Fecha Fin') !!}
            {!! Form::date('fecha_fin', '', ['class'=> 'form-control', 'ReadOnly'=>'true']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-4 col-md-4 col-lg-2">
            {!! Form::label('identificacion','Identificaci&#243;n',['class'=>'required']) !!}
            {!! Form::date('identificacion', '', ['class'=> 'form-control']) !!}
        </div>
        <div class="form-group col-sm-6 col-md-4 col-lg-4">
            {!! Form::label('pendiente','Solo Pendientes de Pago') !!}
            {!! Form::checkbox('pendiente', 1, ['class'=> 'form-control']) !!}
        </div>
    </div>
    <hr/>
    <div>
        {!! Form::submit('Generar',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
@endsection

@section('script')
    <script>
        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '<Ant',
            nextText: 'Sig>',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Mi&#233;rcoles', 'Jueves', 'Viernes', 'S&#225;bado'],
            dayNamesShort: ['Dom','Lun','Mar','Mi&#233;','Juv','Vie','S&#225;b'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&#225;'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['es']);
        $(function() {
            $( "#fecha_inicio" ).datepicker({
                beforeShow: function () {
                    setTimeout(function () {
                        $('.ui-datepicker').css('z-index', 99999999999999);
                    }, 0);
                },
                dateFormat: 'yy-mm-dd',
            })
        });
		$(function() {
            $( "#fecha_fin" ).datepicker({
                beforeShow: function () {
                    setTimeout(function () {
                        $('.ui-datepicker').css('z-index', 99999999999999);
                    }, 0);
                },
                dateFormat: 'yy-mm-dd',
            })
        });
    </script>
@endsection
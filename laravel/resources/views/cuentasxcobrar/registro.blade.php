@extends('layout/master')
<?php $title='Registrar Cuenta Por Cobrar' ?>
<?php $message=Session::get('message') ?>
@if($message == 'ok')
@section('script')
    <script>
        var n = noty({text: 'Cuenta por cobrar registrada correctamente.', type: 'success'});
        setTimeout(function(){
            window.location.reload(1);
        }, 1000)
    </script>
@endsection
@endif
@section('content')
    @include('alerts.request')
    {!! Form::open(['route' => 'registrar_ctaxcobrar', 'class' => 'form']) !!}

    <div class="row">
        <div class="col-sm-6 col-md-3 col-lg-3">
            <label class="required" for="txtIdentification">Buscar Cliente</label>
            <div class="input-group">
                {!! Form::text('txtIdentification','',['class'=> 'form-control', 'type'=>'number', 'id'=>'txtIdentification', 'placeholder'=>'Ingrese C&#233;dula/RUC...']) !!}
               <span class="input-group-btn">
                    <button class="btn btn-primary glyphicon glyphicon-search" type="button" onclick="Buscar()" data-toggle="tooltip" data-placement="bottom" title="Buscar"></button>
               </span>
            </div>
        </div>
        <div class="form-group col-sm-6 col-md-4 col-lg-4">
            {!! Form::label('nombres','Nombres ') !!}
            {!! Form::text('nombres', '', ['class'=> 'form-control', 'ReadOnly'=>'true']) !!}
        </div>
    </div>
    <hr/>

        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
        {!! Form::hidden('cliente_id', '', ['id'=> 'cliente_id']) !!}

        <div class="row">
            <div class="form-group col-sm-4 col-md-2 col-lg-2">
                {!! Form::label('monto','Monto',['class'=>'required']) !!}
                {!! Form::text('monto', '', ['class'=> 'form-control', 'placeholder'=>'0000.00']) !!}
            </div>
            <div class="form-group col-sm-6 col-md-8 col-lg-8">
                {!! Form::label('detalle','Detalle',['class'=>'required']) !!}
                {!! Form::text('detalle', '', ['class'=> 'form-control',]) !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-4 col-md-2 col-lg-2">
                {!! Form::label('fecha_max_pago','Fecha Pago',['class'=>'required']) !!}
                {!! Form::date('fecha_max_pago', '', ['class'=> 'form-control', 'ReadOnly'=>'true']) !!}
            </div>
        </div>
    <hr/>
    <div class="row">
        <div class="col-lg-2">
            {!! Form::submit('Guardar',['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close()  !!}
@endsection

@section('script')
    <script>
            function Buscar() {
                $('#nombres').val('');
                $('#cliente_id').val('');

                var identificacion = $('#txtIdentification').val();
                /*
                 if (isNaN(identificacion)) {
                 $('#txtIdentification').val('');
                 var n = noty({text: 'Ingrese solo n&#250;meros!', type: 'warning'});
                 return;
                 }
                 */
                $.ajax({
                    url: dir+'buscarcliente_ctaxcobrar/' + identificacion,
                    type: 'GET',
                    dataType: 'json',
                    success: function (r) {
                        debugger;
                        $('#cliente_id').val(r.id);
                        $('#nombres').val(r.nombres + " " + r.apellidos);
                        var n = noty({text: 'Cliente encontrado!', type: 'success'});
                    },
                    error: function (r) {
                        var n = noty({
                            text: 'No se encontr&#243; registro con la c&#233;dula ingresada!',
                            type: 'information'
                        });
                    }
                });
            }

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
                $( "#fecha_max_pago" ).datepicker({
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
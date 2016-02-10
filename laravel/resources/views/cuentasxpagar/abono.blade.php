@extends('layout/master')
<?php $title='Abonos Cuentas Por Pagar' ?>

<?php $message=Session::get('message') ?>
@if($message == 'ok')
@section('script')
    <script>
        var n = noty({text: 'Pago registrado Correctamente.', type: 'success'});
    </script>
@endsection
@endif

@section('content')
    @include('alerts.request')
    {!! Form::open(['route' => 'abono_ctaxpagar', 'class' => 'form']) !!}
        <div class="row">
            <div class="col-sm-6 col-md-3 col-lg-3">
                <label class="required" for="txtIdentification">Buscar Proveedor</label>
                <div class="input-group">
                    {!! Form::text('txtIdentification','',['class'=> 'form-control', 'type'=>'number', 'id'=>'txtIdentification', 'placeholder'=>'Ingrese C&#233;dula/RUC...']) !!}
                    <span class="input-group-btn">
                        <button class="btn btn-primary glyphicon glyphicon-search" type="button" onclick="Buscar()" data-toggle="tooltip" data-placement="bottom" title="Buscar"></button>
                   </span>
                </div>
            </div>
        </div>

    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
    {!! Form::hidden('proveedor_id', '', ['id'=> 'proveedor_id']) !!}

    <div class="row">
        <div class="form-group col-sm-6 col-md-4 col-lg-4">
            {!! Form::label('nombres','Nombres') !!}
            {!! Form::text('nombres', '', ['class'=> 'form-control', 'ReadOnly'=>'true']) !!}
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="form-group col-sm-4 col-md-2 col-lg-2">
            {!! Form::label('total','Total') !!}
            {!! Form::text('total', '', ['class'=> 'form-control', 'ReadOnly'=>'true']) !!}
        </div>
        <div class="form-group col-sm-4 col-md-2 col-lg-2">
            {!! Form::label('nfacturas','Numero Facturas') !!}
            {!! Form::text('nfacturas', '', ['class'=> 'form-control', 'ReadOnly'=>'true']) !!}
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="form-group col-sm-4 col-md-2 col-lg-2">
            {!! Form::label('abono','Abono') !!}
            {!! Form::text('abono', '', ['class'=> 'form-control', 'placeholder'=>'0000.00']) !!}
        </div>
        <div class="form-group col-sm-8 col-md-6 col-lg-8">
            {!! Form::label('detalle','Detalle') !!}
            {!! Form::text('detalle', '', ['class'=> 'form-control']) !!}
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
            $('#proveedor_id').val('');

            var identificacion = $('#txtIdentification').val();
            /*
             if (isNaN(identificacion)) {
             $('#txtIdentification').val('');
             var n = noty({text: 'Ingrese solo n&#250;meros!', type: 'warning'});
             return;
             }
             */
            $.ajax({
                url : '/CuentasFacturas/abono_ctaxpagar_ajax/'+identificacion,
                type:'GET',
                dataType: 'json',
                success:function(r)
                {
                    debugger;
                    $('#proveedor_id').val(r[0].proveedor_id);
                    $('#nombres').val(r[0].nombres);
                    $('#total').val(r[0].monto);
                    $('#nfacturas').val(r[0].contador);
                    var n = noty({text: 'Datos encontrados!', type: 'success'});
                },
                error:function(r)
                {
                    debugger;
                    var n = noty({text: 'No se encontr&#243; registro con la c&#233;dula ingresada!', type: 'information'});
                }
            });
        }
    </script>
@endsection
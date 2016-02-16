@extends('layout/master')
<?php $title='Abonos Cuentas Por Cobrar' ?>

@section('content')
    @include('alerts.request')
    {!! Form::open(['route' => 'abonodatos_ctaxcobrar', 'class' => 'form']) !!}
        <div class="row">
            <div class="col-sm-6 col-md-3 col-lg-3">
                <label class="required" for="txtIdentification">Buscar Cliente</label>
                <div class="input-group">
                    {!! Form::text('txtIdentification',$datos[0]->identificacion,['class'=> 'form-control', 'type'=>'number', 'id'=>'txtIdentification', 'placeholder'=>'Ingrese C&#233;dula/RUC...']) !!}
                    <span class="input-group-btn">
                        <button class="btn btn-primary glyphicon glyphicon-search" type="button" onclick="Buscar()" data-toggle="tooltip" data-placement="bottom" title="Buscar"></button>
                   </span>
                </div>
            </div>
        </div>

    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
    {!! Form::hidden('cliente_id', $datos[0]->cliente_id, ['id'=> 'cliente_id']) !!}

    <div class="row">
        <div class="form-group col-sm-6 col-md-4 col-lg-4">
            {!! Form::label('nombres','Nombres') !!}
            {!! Form::text('nombres', $datos[0]->nombres, ['class'=> 'form-control', 'ReadOnly'=>'true']) !!}
        </div>
        <div class="form-group col-sm-6 col-md-4 col-lg-4">
            {!! Form::label('apellidos','Apellidos') !!}
            {!! Form::text('apellidos', $datos[0]->apellidos, ['class'=> 'form-control', 'ReadOnly'=>'true']) !!}
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="form-group col-sm-4 col-md-2 col-lg-2">
            {!! Form::label('total','Total') !!}
            {!! Form::text('total', $datos[0]->monto, ['class'=> 'form-control', 'ReadOnly'=>'true']) !!}
        </div>
        <div class="form-group col-sm-4 col-md-2 col-lg-2">
            {!! Form::label('nfacturas','Numero Facturas') !!}
            {!! Form::text('nfacturas', $datos[0]->contador, ['class'=> 'form-control', 'ReadOnly'=>'true']) !!}
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
                url : dir+'abono_ctaxcobrar_ajax/'+identificacion,
                type:'GET',
                dataType: 'json',
                success:function(r)
                {
                    debugger;
                    $('#cliente_id').val(r[0].cliente_id);
                    $('#nombres').val(r[0].nombres);
                    $('#apellidos').val(r[0].apellidos);
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
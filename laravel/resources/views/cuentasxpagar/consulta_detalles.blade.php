@extends('layout/master')
<?php $title='Detalles de facturas'; $total_deuda = 0; $total_saldo=0; ?>

@section('content')
    <div class="row">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 ">
            <small><a href="{{route('consulta_ctaxpagar')}}" class="btn btn-info glyphicon glyphicon-arrow-left btn-sm" title="Volver"></a></small>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 ">
            <small><a href="{{route('abonodatos_ctaxpagar',$facturas[0]->proveedor_id)}}" class="btn btn-default glyphicon glyphicon glyphicon-usd btn-sm" title="Ir a pagos"></a></small>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 ">
            <small><a href="{{route('rep_ctasproveedor',$facturas[0]->proveedor_id)}}" target="_blank" class="btn btn-default glyphicon glyphicon glyphicon-print btn-sm" title="Imprimir PDF"></a></small>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="form-group col-sm-4 col-md-4 col-lg-2 ">
            {!! Form::label('identificacion', 'C&#233;dula/RUC') !!}
            {!! Form::text('identificacion', $facturas[0]->identificacion, ['class'=> 'form-control', 'ReadOnly'=>'true']) !!}
        </div>
    </div>

    <div class="row">
        <div class="form-group col-sm-6 col-md-4 col-lg-4">
            {!! Form::label('nombres','Nombres') !!}
            {!! Form::text('nombres', $facturas[0]->nombres, ['class'=> 'form-control', 'ReadOnly'=>'true']) !!}
        </div>
    </div>
    <hr/>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Fecha registro</th>
                <th>Detalle</th>
                <th>Monto</th>
                <th>Saldo</th>
                <th>Fecha Max. Pago</th>
                <th>Estado</th>
            </tr>
            </thead>
            <tbody>
            @foreach( $facturas as $item)
                <tr>
                    <td>{{$item->created_at}}</td>
                    <td>{{$item->detalle}}</td>
                    <td>{{$item->monto}}</td>
                    <td>{{$item->saldo}}</td>
                    <td>{{$item->fecha_max_pago}}</td>
                    <td>{{$item->estado_activo==1?'Pendiente':'Pagado'}}</td>
                </tr>
                <?php
                    $total_deuda = $total_deuda + $item->monto;
                    $total_saldo = $total_saldo + $item->saldo;
                ?>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th></th>
                    <th>{{$total_deuda}}</th>
                    <th>{{$total_saldo}}</th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>

@endsection
@section('content_extend')
    {!! $facturas->render() !!}
@endsection
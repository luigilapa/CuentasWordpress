@extends('layout/master')
<?php $title='Cuentas Por Cobrar' ?>

<?php $message=Session::get('message') ?>
@if($message == 'ok')
@section('script')
    <script>
        var n = noty({text: 'Pago registrado Correctamente.', type: 'success'});
    </script>
@endsection
@endif
@if($message == 'error_consulta')
@section('script')
    <script>
        var n = noty({text: 'No se encontraron facturas pendientes.', type: 'info'});
    </script>
@endsection
@endif

@section('content')
    <div class="row">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 ">
            <small><a href="{{route("rep_ctaxcobrar")}}" target="_blank" class="btn btn-default glyphicon glyphicon glyphicon-print btn-sm" title="Imprimir PDF"></a></small>
        </div>
    </div>
    <hr/>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Identificaci&#243;n</th>
                <th>Cliente</th>
                <th>Facturas</th>
                <th>Total</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach( $ctasxcobrar as $item)
                <tr>
                    <td>{{$item->identificacion}}</td>
                    <td>{{$item->nombres." ".$item->apellidos}}</td>
                    <td>{{$item->contador}}</td>
                    <td>{{$item->monto}}</td>
                    <td>
                        <small><a href="{{route('detalle_ctaxcobrar',$item->cliente_id)}}" class="btn btn-info glyphicon glyphicon-eye-open btn-xs" title="Ver Detalles"></a></small>
                    </td>
                    <td>
                        <small><a href="{{route('abonodatos_ctaxcobrar',$item->cliente_id)}}" class="btn btn-default glyphicon glyphicon glyphicon-usd btn-xs" title="Ir a pagos"></a></small>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('content_extend')
    {!! $ctasxcobrar->render() !!}
@endsection
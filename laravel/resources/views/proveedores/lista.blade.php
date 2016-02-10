@extends('layout/master')

<?php $title='Lista Proveedores' ?>

<?php $message=Session::get('message') ?>
@if($message == 'ok')
@section('script')
    <script>
        var n = noty({text: 'Proveedor registrado Correctamente!', type: 'success'});
    </script>
@endsection
@endif
@if($message == 'editok')
@section('script')
    <script>
        var n = noty({text: 'Proveedor actualizado Correctamente!', type: 'success'});
    </script>
@endsection
@endif
@if($message == 'anularok')
@section('script')
    <script>
        var n = noty({text: 'Proveedor Anulado Correctamente!', type: 'success'});
    </script>
@endsection
@endif

@section('content')
    <div class="row">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 ">
            <small><a href="{{route("rep_proveedores")}}" target="_blank" class="btn btn-default glyphicon glyphicon glyphicon-print btn-sm" title="Imprimir PDF"></a></small>
        </div>
    </div>
    <hr/>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Identificaci&#243;n</th>
                <th>Nombres</th>
                <th>Correo</th>
                <th>Direcci&#243;n</th>
                <th>Tel&#233;fono</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach( $proveedores as $proveedor)
                <tr>
                    <td>{{$proveedor->identificacion}}</td>
                    <td>{{$proveedor->nombres}}</td>
                    <td>{{$proveedor->correo}}</td>
                    <td>{{$proveedor->direccion}}</td>
                    <td>{{$proveedor->telefono}}</td>
                    <td>
                        <small><a href="{{route('editar_proveedor',$proveedor->id)}}" class="btn btn-default glyphicon glyphicon-pencil btn-xs" title="Editar"></a></small>
                    </td>
                    <td>
                        @if(Auth::user()->type == 'administrador')
                        <!--<small><a href="{{route('anular_proveedor',$proveedor->id)}}" class="btn btn-danger glyphicon glyphicon-remove-sign btn-xs" title="Anular"></a></small>-->
                        <small><a onclick="Anular($(this).data('id'))" data-id="{!! $proveedor->id !!}" class="btn btn-warning glyphicon glyphicon-remove-sign btn-xs" title="Anular"></a></small>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
@section('content_extend')
    {!! $proveedores->render() !!}
@endsection

@section('script')
    <script>
        function Anular(id) {
            noty({
                text: '&#191;Est&#225; seguro de querer anular el proveedor?',
                buttons: [
                    {addClass: 'btn btn-primary', text: 'Si', onClick: function($noty) {
                        $noty.close();
                        var token = $('#token').val();
                        //***************//
                        $.ajax({
                            url : '/CuentasFacturas/anular_proveedor/'+id,
                            headers:{'X-CSRF-TOKEN' : token},
                            type:'GET',
                            dataType: 'json',
                            success:function(r)
                            {
                                if(r.mensaje == "ok") {
                                    window.location.reload();
                                    var n = noty({text: 'Proveedor anulado correctamente!', type: 'success'});
                                }
                            },
                            error:function(r)
                            {
                                debugger;
                                var s = r;
                                var n = noty({text: 'Errores!', type: 'error'});
                            }
                        });
                        //**************//
                    }
                    },
                    {addClass: 'btn btn-danger', text: 'Cancelar', onClick: function($noty) {
                        $noty.close();
                        noty({text: 'Acci&#243;n Cancelada ', type: 'information'});
                    }
                    }
                ]
            });

        }
    </script>
@endsection
@extends('layout/master')

<?php $title='Lista Clientes Anulados' ?>

<?php $message=Session::get('message') ?>

@section('content')
    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th></th>
                <th>Identificaci&#243;n</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Correo</th>
                <th>Direcci&#243;n</th>
                <th>Tel&#233;fono</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach( $clientes as $cliente)
                <tr>
                    <td>
                        @if(Auth::user()->type == 'administrador')
                        <small><a id="cliente_restore" onclick="Restaurar($(this).data('id'))" data-id="{!! $cliente->id !!}"  class="btn btn-success glyphicon glyphicon-refresh btn-xs" title="Restaurar" data-toggle="modal" data-target="#myModalRestore" onclick=""></a></small>
                        @endif
                    </td>
                    <td>{{$cliente->identificacion}}</td>
                    <td>{{$cliente->nombres}}</td>
                    <td>{{$cliente->apellidos}}</td>
                    <td>{{$cliente->correo}}</td>
                    <td>{{$cliente->direccion}}</td>
                    <td>{{$cliente->telefono}}</td>
                    <td>
                        @if(Auth::user()->type == 'administrador')
                        <small><a id="cliente_delete" onclick="Eliinar($(this).data('id'))" data-id="{!! $cliente->id !!}"  class="btn btn-danger glyphicon glyphicon-trash btn-xs" title="Eliminar" data-toggle="modal" data-target="#myModalRestore" onclick=""></a></small>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
@section('content_extend')
    {!! $clientes->render() !!}
@endsection

@section('script')
    <script>
        function Restaurar(id) {
            noty({
                text: '&#191;Est&#225; seguro de querer restaurar el cliente?',
                buttons: [
                    {addClass: 'btn btn-primary', text: 'Si', onClick: function($noty) {
                        $noty.close();
                        var token = $('#token').val();
                        //***************//
                        $.ajax({
                            url : '/CuentasFacturas/restaurar_cliente/'+id,
                            headers:{'X-CSRF-TOKEN' : token},
                            type:'GET',
                            dataType: 'json',
                            success:function(r)
                            {
                                if(r.mensaje == "ok") {
                                    window.location.reload();
                                    var n = noty({text: 'Cliente restaurado correctamente!', type: 'success'});
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

        function Eliminar(id) {
            noty({
                text: '&#191;Est&#225; seguro de querer eliminar el cliente?',
                buttons: [
                    {addClass: 'btn btn-primary', text: 'Si', onClick: function($noty) {
                        $noty.close();
                        var token = $('#token').val();
                        //***************//
                        $.ajax({
                            url : '/CuentasFacturas/eliminar_cliente/'+id,
                            headers:{'X-CSRF-TOKEN' : token},
                            type:'GET',
                            dataType: 'json',
                            success:function(r)
                            {
                                if(r.mensaje == "ok") {
                                    window.location.reload();
                                    var n = noty({text: 'Cliente eliminado correctamente!', type: 'success'});
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
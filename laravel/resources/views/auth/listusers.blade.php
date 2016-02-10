@extends('layout/master')

<?php $title='Lista Usuarios' ?>

<?php $message=Session::get('message') ?>
@if($message == 'ok')
    @section('script')
        <script>
            var n = noty({text: 'Usuario registrado Correctamente.', type: 'success'});
        </script>
    @endsection
@endif
@if($message == 'editok')
@section('script')
    <script>
        var n = noty({text: 'Usuario actualizado Correctamente!', type: 'success'});
    </script>
@endsection
@endif

@section('content')
    <div class="row">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 ">
            <small><a href="{{route("rep_usuarios")}}" target="_blank" class="btn btn-default glyphicon glyphicon glyphicon-print btn-sm" title="Imprimir PDF"></a></small>
        </div>
    </div>
    <hr/>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
    <div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th>Nombres</th>
            <th>Usuario</th>
            <th>Correo</th>
            <th>Tipo</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach( $users as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->username}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->type}}</td>
                <td>
                    @if(Auth::user()->type == 'administrador')
                    <small><a href="{{route('user_edit',$user->id)}}" class="btn btn-default glyphicon glyphicon-pencil btn-xs" title="Editar"></a></small>
                    @endif
                </td>
                <td>
                    @if(Auth::user()->type == 'administrador')
                    <small><a onclick="CancelUser($(this).data('id'))" data-id="{!! $user->id !!}" class="btn btn-warning glyphicon glyphicon-remove-sign btn-xs" title="Anular"></a></small>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>

@endsection
@section('content_extend')
    {!! $users->render() !!}
@endsection

@section('script')
    <script>
        function CancelUser(id) {
            noty({
                text: '&#191;Est&#225; seguro de querer anular este usuario?',
                buttons: [
                    {addClass: 'btn btn-primary', text: 'Si', onClick: function($noty) {
                        $noty.close();
                        var token = $('#token').val();
                        //***************//
                        $.ajax({
                            url : '/CuentasFacturas/user_cancel/'+id,
                            headers:{'X-CSRF-TOKEN' : token},
                            type:'GET',
                            dataType: 'json',
                            success:function(r)
                            {
                                if(r.mensaje == "ok") {
                                    window.location.reload();
                                    var n = noty({text: 'Usuario anulado correctamente!', type: 'success'});
                                }
                                if(r.mensaje == "login") {
                                    var n = noty({text: 'Usuario logiado actualmente!', type: 'information'});
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
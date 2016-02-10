@extends('layout/assets')

@section('content')
<div class="row" style="text-align: center; margin-top: 10%;">
    <div class="col-lg-12">
        <span class="glyphicon glyphicon-fire text-danger"><h1>Error 404</h1></span>
        <h2>No se encontró la p&#225;gina solicitada.</h2>
    </div>
    <div class="col-lg-12">
        <a href="{!! route('home') !!}">Regresar al inicio</a>
    </div>
</div>
@endsection
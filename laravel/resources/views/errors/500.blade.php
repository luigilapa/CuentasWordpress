@extends('layout/assets')

@section('content')
    <div class="row" style="text-align: center; margin-top: 10%;">
        <div class="col-lg-12">
            <span class="glyphicon glyphicon-fire text-danger"><h2>Error 500</h2></span>
            <h1>Hemos tenidos problemas para intentar resolver su solicitud, por favor vuelva a intentarlo.</h1>
        </div>
        <div class="col-lg-12">
            <a href="{!! route('home') !!}">Regresar al inicio</a>
        </div>
    </div>
@endsection
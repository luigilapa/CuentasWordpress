@extends('layout/master')
<?php $title='Editar Cliente' ?>

<?php $message=Session::get('message') ?>
@if($message == 'ok')
@section('script')
    <script>
        var n = noty({text: 'Cliente registrado Correctamente!', type: 'success'});
    </script>
@endsection
@endif

@section('content')
    @include('alerts.request')
    {!! Form::open(['route' => 'editar_cliente', 'class' => 'form']) !!}
    {!! Form::hidden('id', $cliente->id, ['id'=> 'id']) !!}
    <div class="row">
        <div class="form-group col-sm-6 col-md-6 col-lg-3 ">
            {!! Form::label('identificacion', 'C&#233;dula/RUC',['class'=>'required']) !!}
            {!! Form::number('identificacion', $cliente->identificacion, ['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="row">
        <div class="form-group col-sm-6 col-md-6 col-lg-6">
            {!! Form::label('nombres','Nombres',['class'=>'required']) !!}
            {!! Form::text('nombres', $cliente->nombres, ['class'=> 'form-control']) !!}
        </div>
        <div class="form-group col-sm-6 col-md-6 col-lg-6">
            {!! Form::label('apellidos','Apellidos',['class'=>'required']) !!}
            {!! Form::text('apellidos', $cliente->apellidos, ['class'=> 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-6 col-md-6 col-lg-6">
            {!! Form::label('correo','Correo Electr&#243;nico ') !!}
            {!! Form::email('correo', $cliente->correo, ['class'=> 'form-control']) !!}
        </div>
        <div class="form-group col-sm-6 col-md-3 col-lg-3">
            {!! Form::label('telefono','Tel&#233;fono') !!}
            {!! Form::number('telefono', $cliente->telefono, ['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="row">
        <div class="form-group col-sm-9 col-md-9 col-lg-10">
            {!! Form::label('direccion','Direeci&#243;n') !!}
            {!! Form::text('direccion', $cliente->direccion, ['class'=> 'form-control']) !!}
        </div>
    </div>
    <hr/>
    <div>
        {!! Form::submit('Actualizar',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
@endsection
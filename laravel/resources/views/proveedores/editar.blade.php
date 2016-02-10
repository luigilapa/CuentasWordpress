@extends('layout/master')
<?php $title='Editar Proveedor' ?>

<?php $message=Session::get('message') ?>
@if($message == 'ok')
@section('script')
    <script>
        var n = noty({text: 'Proveedor registrado Correctamente!', type: 'success'});
    </script>
@endsection
@endif

@section('content')
    @include('alerts.request')
    {!! Form::open(['route' => 'editar_proveedor', 'class' => 'form']) !!}
    {!! Form::hidden('id', $proveedor->id, ['id'=> 'id']) !!}
    <div class="row">
        <div class="form-group col-sm-6 col-md-6 col-lg-3 ">
            {!! Form::label('identificacion', 'C&#233;dula/RUC',['class'=>'required']) !!}
            {!! Form::number('identificacion', $proveedor->identificacion, ['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="row">
        <div class="form-group col-sm-6 col-md-6 col-lg-6">
            {!! Form::label('nombres','Nombres',['class'=>'required']) !!}
            {!! Form::text('nombres', $proveedor->nombres, ['class'=> 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-6 col-md-6 col-lg-6">
            {!! Form::label('correo','Correo Electr&#243;nico ') !!}
            {!! Form::email('correo', $proveedor->correo, ['class'=> 'form-control']) !!}
        </div>
        <div class="form-group col-sm-6 col-md-3 col-lg-3">
            {!! Form::label('telefono','Tel&#233;fono') !!}
            {!! Form::number('telefono', $proveedor->telefono, ['class'=> 'form-control']) !!}
        </div>
    </div>

    <div class="row">
        <div class="form-group col-sm-9 col-md-9 col-lg-10">
            {!! Form::label('direccion','Direeci&#243;n') !!}
            {!! Form::text('direccion', $proveedor->direccion, ['class'=> 'form-control']) !!}
        </div>
    </div>
    <hr/>
    <div>
        {!! Form::submit('Actualizar',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
@endsection
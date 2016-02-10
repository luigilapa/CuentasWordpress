<?php

Route::get('registrar_ctaxcobrar', [
    'as' => 'registrar_ctaxcobrar',
    'uses' => 'CuentasCobrarController@getRegistro'
]);
Route::post('registrar_ctaxcobrar',  'CuentasCobrarController@postRegistro' );


Route::get('buscarcliente_ctaxcobrar/{id}', [
    'as' => 'buscarcliente_ctaxcobrar',
    'uses' => 'CuentasCobrarController@getBuscarCliente'
]);

Route::get('consulta_ctaxcobrar', [
    'as' => 'consulta_ctaxcobrar',
    'uses' => 'CuentasCobrarController@getConsulta'
]);

Route::get('detalle_ctaxcobrar/{cliente_id}', [
    'as' => 'detalle_ctaxcobrar',
    'uses' => 'CuentasCobrarController@getConsultaDetalles'
]);

Route::get('abono_ctaxcobrar', [
    'as' => 'abono_ctaxcobrar',
    'uses' => 'CuentasCobrarController@getAbonos'
]);
Route::post('abono_ctaxcobrar', 'CuentasCobrarController@postAbonos' );

Route::get('abono_ctaxcobrar_ajax/{cliente_id}', [
    'as' => 'abono_ctaxcobrar_ajax',
    'uses' => 'CuentasCobrarController@getAbonosAjax'
]);

Route::get('abonodatos_ctaxcobrar/{cliente_id?}', [
    'as' => 'abonodatos_ctaxcobrar',
    'uses' => 'CuentasCobrarController@getAbonosDatos'
]);
Route::post('abonodatos_ctaxcobrar', 'CuentasCobrarController@postAbonosDatos' );
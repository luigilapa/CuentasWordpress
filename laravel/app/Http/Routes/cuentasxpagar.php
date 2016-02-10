<?php

Route::get('registrar_ctaxpagar', [
    'as' => 'registrar_ctaxpagar',
    'uses' => 'CuentasPagarController@getRegistro'
]);
Route::post('registrar_ctaxpagar',  'CuentasPagarController@postRegistro' );

Route::get('buscarproveedor_ctaxpagar/{id}', [
    'as' => 'buscarproveedor_ctaxpagar',
    'uses' => 'CuentasPagarController@getBuscarProveedor'
]);

Route::get('consulta_ctaxpagar', [
    'as' => 'consulta_ctaxpagar',
    'uses' => 'CuentasPagarController@getConsulta'
]);

Route::get('detalle_ctaxpagar/{proveedor_id}', [
    'as' => 'detalle_ctaxpagar',
    'uses' => 'CuentasPagarController@getConsultaDetalles'
]);

Route::get('abono_ctaxpagar', [
    'as' => 'abono_ctaxpagar',
    'uses' => 'CuentasPagarController@getAbonos'
]);
Route::post('abono_ctaxpagar', 'CuentasPagarController@postAbonos' );

Route::get('abono_ctaxpagar_ajax/{proveedor_id}', [
    'as' => 'abono_ctaxpagar_ajax',
    'uses' => 'CuentasPagarController@getAbonosAjax'
]);

Route::get('abonodatos_ctaxpagar/{proveedor_id?}', [
    'as' => 'abonodatos_ctaxpagar',
    'uses' => 'CuentasPagarController@getAbonosDatos'
]);
Route::post('abonodatos_ctaxpagar', 'CuentasPagarController@postAbonosDatos' );
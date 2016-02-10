<?php

Route::get('rep_ctascliente/{cliente_id}', [
    'as' => 'rep_ctascliente',
    'uses' => 'Reportes\ReportesCuentasCobrarController@getCuentasClientes'
]);

Route::get('rep_ctasproveedor/{proveedor_id}', [
    'as' => 'rep_ctasproveedor',
    'uses' => 'Reportes\ReportesCuentasPagarController@getCuentasProveedor'
]);

Route::get('rep_ctaxcobrar', [
    'as' => 'rep_ctaxcobrar',
    'uses' => 'Reportes\ReportesCuentasCobrarController@getCuentas'
]);

Route::get('rep_ctaxpagar', [
    'as' => 'rep_ctaxpagar',
    'uses' => 'Reportes\ReportesCuentasPagarController@getCuentas'
]);

Route::get('rep_clientes', [
    'as' => 'rep_clientes',
    'uses' => 'Reportes\ReportesClientesController@getClientes'
]);

Route::get('rep_proveedores', [
    'as' => 'rep_proveedores',
    'uses' => 'Reportes\ReportesProvedoresController@getProveedores'
]);

Route::get('rep_usuarios', [
    'as' => 'rep_usuarios',
    'uses' => 'Reportes\ReportesUsuariosController@getUsuarios'
]);

Route::get('registro_cuenta', [
    'as' => 'registro_cuenta',
    'uses' => 'Reportes\ReportesConstructorController@getRegistroCuenta'
]);
Route::post('registro_cuenta', 'Reportes\ReportesConstructorController@postRegistroCuenta' );
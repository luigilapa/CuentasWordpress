<?php

Route::get('lista_proveedores', [
    'as' => 'lista_proveedores',
    'uses' => 'ProveedoresController@getList'
]);

Route::get('registrar_proveedor', [
    'as' => 'registrar_proveedor',
    'uses' => 'ProveedoresController@getRegistro'
]);
Route::post('registrar_proveedor',  'ProveedoresController@postRegistro' );

Route::get('editar_proveedor/{id}', [
    'as' => 'editar_proveedor',
    'uses' => 'ProveedoresController@getEditar'
]);
Route::post('editar_proveedor/{id}', 'ProveedoresController@postEditar' );

Route::get('anular_proveedor/{id}', [
    'as' => 'anular_proveedor',
    'uses' => 'ProveedoresController@getAnular'
]);

Route::get('anulados_proveedores', [
    'as' => 'anulados_proveedores',
    'uses' => 'ProveedoresController@getAnulados'
]);

Route::get('restaurar_proveedor/{id}', [
    'as' => 'restaurar_proveedor',
    'uses' => 'ProveedoresController@getRestaurar'
]);

Route::get('eliminar_proveedor/{id}', [
    'as' => 'eliminar_proveedor',
    'uses' => 'ProveedoresController@getEliminar'
]);
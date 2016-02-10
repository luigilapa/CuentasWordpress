<?php
Route::get('lista_clientes', [
    'as' => 'lista_clientes',
    'uses' => 'ClientesController@getList'
]);

Route::get('registrar_cliente', [
    'as' => 'registrar_cliente',
    'uses' => 'ClientesController@getRegistro'
]);
Route::post('registrar_cliente',  'ClientesController@postRegistro' );

Route::get('editar_cliente/{id}', [
    'as' => 'editar_cliente',
    'uses' => 'ClientesController@getEditar'
]);
Route::post('editar_cliente/{id}', 'ClientesController@postEditar' );

Route::get('anular_cliente/{id}', [
    'as' => 'anular_cliente',
    'uses' => 'ClientesController@getAnular'
]);

Route::get('anulados_clientes', [
    'as' => 'anulados_clientes',
    'uses' => 'ClientesController@getAnulados'
]);

Route::get('restaurar_cliente/{id}', [
    'as' => 'restaurar_cliente',
    'uses' => 'ClientesController@getRestaurar'
]);

Route::get('eliminar_cliente/{id}', [
    'as' => 'eliminar_cliente',
    'uses' => 'ClientesController@getEliminar'
]);
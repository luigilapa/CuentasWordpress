<?php

Route::get('login', [
    'as' => 'login',
    'uses' => 'Auth\AuthController@getLogin'
]);
Route::post('login', 'Auth\AuthController@postLogin');

Route::get('logout', [
    'as' => 'logout',
    'uses' => 'Auth\AuthController@getLogout'
]);

Route::get('/', [
    'as' => '/',
    'uses' => function () {
        return view('welcome');
    }
]);

Route::group(['middleware' => 'auth'], function (){

    Route::get('401', function()
    {
        return view('errors.401');
    });

    Route::get('home', [
        'as' => 'home',
        'uses' => 'HomeController@index'
    ]);
});


require app_path('Http/Routes/usuarios.php');
require app_path('Http/Routes/clientes.php');
require app_path('Http/Routes/proveedores.php');
require app_path('Http/Routes/cuentasxcobrar.php');
require app_path('Http/Routes/cuentasxpagar.php');
require app_path('Http/Routes/reporte.php');

<?php
Route::get('user_register', [
    'as' => 'user_register',
    'uses' => 'Auth\AuthController@getRegister'
]);
Route::post('user_register',  'Auth\AuthController@postRegister' );

Route::get('user_list', [
    'as' => 'user_list',
    'uses' => 'Auth\AuthController@getListUsers'
]);

Route::get('user_reset', [
    'as' => 'user_reset',
    'uses' => 'Auth\PasswordController@getReset'
]);
Route::post('user_reset', 'Auth\PasswordController@postReset' );

Route::get('user_edit/{id?}', [
    'as' => 'user_edit',
    'uses' => 'Auth\AuthController@getEdit'
]);
Route::post('user_edit',  'Auth\AuthController@postEdit' );

Route::get('user_cancel/{id}', [
    'as' => 'user_cancel',
    'uses' => 'Auth\AuthController@getCancel'
]);

Route::get('user_restart/{id}', [
    'as' => 'user_restart',
    'uses' => 'Auth\AuthController@getRestart'
]);

Route::get('user_out', [
    'as' => 'user_out',
    'uses' => 'Auth\AuthController@getOutUser'
]);
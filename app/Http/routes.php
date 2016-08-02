<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return response()->json([
        'message' => 'Bem vindo a api para controle de focas',
        'data_atual' => date('d/m/Y'),
        'hora_atual' => date('H:i:s')
    ]);
});

// SEALS ROUTES // -----------------------------------------------------------------------------------------------------
Route::get('/seals', 'SealsController@index');
Route::get('/seals/{id}', 'SealsController@show');
Route::post('/seals', 'SealsController@store');
Route::put('/seals/{id}', 'SealsController@update');
Route::delete('/seals/{id}', 'SealsController@destroy');
Route::get('/most-productive', 'SealsController@mostProductive');

// BABY SEALS ROUTES ---------------------------------------------------------------------------------------------------

Route::get('/baby-seals', 'BabySealsController@index');
Route::get('/baby-seals/{id}', 'BabySealsController@show');
Route::post('/baby-seals', 'BabySealsController@store');
Route::put('/baby-seals/{id}', 'BabySealsController@update');
Route::delete('/baby-seals/{id}', 'BabySealsController@destroy');
Route::get('/mothers', 'BabySealsController@seals');



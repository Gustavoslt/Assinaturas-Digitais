<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('assinatura/{id}','AssinaturasController@index')->name('assinatura');
Route::post('assinatura/{id}','AssinaturasController@upload')->name('assinatura.upload');
Route::get('download/{id}','DocumentosController@download');

Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');

// Route::get('/assinatura', function () {
//     return view('assinatura');
// });

// Auth::routes();



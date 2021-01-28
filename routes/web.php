<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('candidato', 'CandidatoController');

    Route::get('candidato/delete/{id}', ['as' => 'candidato.delete', 'uses' => 'CandidatoController@destroy']);
    // Route::get('/candidato', 'CandidatoController@index');
    // Route::get('/candidato/create', 'CandidatoController@create');
    // Route::post('/candidato/store', 'CandidatoController@store');
});

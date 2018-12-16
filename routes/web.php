<?php

use Illuminate\Http\Request;

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
    return view('welcome');
})->middleware('verified');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('invoice', function() {
    return view('invoice');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::post('/contact', function (Request $request) {
    //
});

Route::get('{path}', 'HomeController@index')->where('path', '([A-z\d-\/_.]+)?');





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

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home',       'HomeController@index');
Route::get('/home/{esrequest}',  'HomeController@show');

Route::get ('/create',    'EsrequestsController@create');
Route::post('/create',    'EsrequestsController@store');

Route::get ('/admin',      'EsrequestsController@new');
Route::get ('/admin/all',  'EsrequestsController@index');
Route::get ('/admin/{esrequest}', 'EsrequestsController@show');
Route::post('/admin/{esrequest}', 'EsrequestsController@fulfill');

Route::get('/instructions', function() {
    return view('instructions');
});

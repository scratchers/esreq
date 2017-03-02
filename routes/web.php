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

Route::group(['middleware' => 'auth'], function(){
    Route::resource(
        'requests',
        'Customer\EsrequestsController',
        ['as' => 'customer']
    );

    Route::resource(
        'admin/requests',
        'Admin\EsrequestsController',
        ['as' => 'admin']
    );
});

Route::name('instructions')->get('/instructions', function() {
    return view('instructions');
});

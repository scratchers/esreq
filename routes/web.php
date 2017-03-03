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
    Route::name('home')->get('/home', function () {
        if ( Auth::user()->isAdmin() ) {
            return redirect(route('admin.requests.unfulfilled'));
        }
        return redirect(route('customer.requests.index'));
    });

    Route::resource(
        'requests',
        'Customer\EsrequestsController',
        [
            'as' => 'customer',
            'parameters' => [
                'requests' => 'esrequest',
            ],
        ]
    );

    Route::name('admin.requests.fulfill')
         ->post('admin/requests/{esrequest}', 'Admin\EsrequestsController@fulfill');
    Route::name('admin.requests.unfulfilled')
         ->get ('admin/requests/unfulfilled', 'Admin\EsrequestsController@unfulfilled');
    Route::resource(
        'admin/requests',
        'Admin\EsrequestsController',
        [
            'as' => 'admin',
            'parameters' => [
                'requests' => 'esrequest',
            ],
        ]
    );

    Route::name('reports')->get('/reports', function () {
        return redirect(route('reports.institutions'));
    });
    Route::name('reports.institutions')
         ->get ('reports/institutions', 'ReportsController@institutions');
});

Route::name('instructions')->get('/instructions', function() {
    return view('instructions');
});

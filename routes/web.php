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
        return view('home');
    });

    Route::name('admin')
         ->get('/admin', function () {
            if ( Auth::user()->isAdmin() ) {
                return view('admin');
            }
            return abort(403, "Administrative Access Required");
        });

    if ( env('APP_ENV') === 'local' ) {
    Route::name('impersonate')
         ->get('/impersonate/{user}', function(App\User $user){
            if ( Auth::user()->isAdmin() ) {
                Auth::login($user);
                return redirect(route('home'));
            }
            return abort(403, "Administrative Access Required");
         });
    }

    Route::name('customer.requests.facacc')
         ->get ('customer/requests/{esrequest}/facacc', 'Customer\EsrequestsController@facacc');
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


    Route::resource(
        'facultyAccount',
        'Customer\FacultyAccountController',
        [
            'as' => 'customer',
        ]
    );

    Route::name('admin.facultyAccount.assign')
         ->get ('admin/facultyAccount/assign/{user}', 'Admin\FacultyAccountController@assign');
    Route::name('admin.facultyAccount.addplatform')
         ->get ('admin/facultyAccount/{facultyAccount}/addplatform/{platform}', 'Admin\FacultyAccountController@addplatform');
    Route::name('admin.facultyAccount.rmplatform')
         ->get ('admin/facultyAccount/{facultyAccount}/rmplatform/{platform}', 'Admin\FacultyAccountController@rmplatform');
    Route::resource(
        'admin/facultyAccount',
        'Admin\FacultyAccountController',
        [
            'as' => 'admin',
        ]
    );


    Route::name('report')
         ->get ('/report', 'ReportsController@index');

    Route::name('report.institutions.index')
         ->get ('report/institutions', 'ReportsController@institutions');
    Route::name('report.institutions.show')
         ->get ('report/institutions/{institution}', 'ReportsController@institution');

    Route::name('report.users.index')
         ->get ('report/users', 'ReportsController@users');
    Route::name('report.users.show')
         ->get ('report/users/{user}', 'ReportsController@user');

    Route::name('report.requests.index')
         ->get ('report/requests', 'ReportsController@requests');
    Route::name('report.requests.show')
         ->get ('report/requests/{esrequest}', 'ReportsController@request');
});

Route::name('instructions')->get('/instructions', function() {
    return view('instructions');
});

<?php

namespace App\Http\Controllers;

use App\Esrequest;
use Illuminate\Http\Request;
use Auth;

class EsrequestsController extends Controller
{
    function new()
    {
        $esrequests = Esrequest::whereNull('fulfilled_at')->get();

        $esrequests->controller = 'EsrequestsController@show';

        return view('esrequests.index', compact('esrequests'));
    }
}

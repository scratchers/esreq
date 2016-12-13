<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Esrequest;

class EsrequestsController extends Controller
{
    function index()
    {
        $esrequests = Esrequest::all();
        $fields = $esrequests->first()->fields();
        return view('esrequests.index', compact('esrequests', 'fields'));
    }
}

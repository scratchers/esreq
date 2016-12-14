<?php

namespace App\Http\Controllers;

use Request;
use App\Esrequest;

class EsrequestsController extends Controller
{
    function index()
    {
        $esrequests = Esrequest::all();
        $fields = $esrequests->first()->fields();
        return view('esrequests.index', compact('esrequests', 'fields'));
    }

    function show($id)
    {
        $esrequest = Esrequest::findOrFail($id);
        $fields = $esrequest->fields();
        return view('esrequests.show', compact('esrequest', 'fields'));
    }

    function create()
    {
        return view('esrequests.create');
    }

    function store()
    {
        Esrequest::create(Request::all());
        return redirect('esrequests');
    }
}

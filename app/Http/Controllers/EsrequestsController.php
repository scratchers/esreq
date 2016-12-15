<?php

namespace App\Http\Controllers;

use App\Esrequest;
use App\Http\Requests\CreateEsrequest;

class EsrequestsController extends Controller
{
    function index()
    {
        $esrequests = Esrequest::all();
        $fields = null !== $esrequests->first() ? $esrequests->first()->fields() : [];
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

    function store(CreateEsrequest $request)
    {
        Esrequest::create($request->all());
        return redirect('esrequests');
    }
}

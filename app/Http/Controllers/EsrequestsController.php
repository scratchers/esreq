<?php

namespace App\Http\Controllers;

use App\Esrequest;
use App\Http\Requests\CreateEsrequest;
use Auth;

class EsrequestsController extends Controller
{
    function __construct()
    {
        $this->middleware('auth', ['only' => 'create']);
    }

    function index()
    {
        $esrequests = Esrequest::all();
        return view('esrequests.index', compact('esrequests'));
    }

    function show($id)
    {
        $esrequest = Esrequest::findOrFail($id);
        $fields = array_merge(
            ['platforms' => $esrequest->getPlatforms(true)],
            $esrequest->getAllValuesFor('accounts', 'metadata'),
            $esrequest->getValuesFor('courseInfo')
        );
        return view('esrequests.show', compact('esrequest', 'fields'));
    }

    function create()
    {
        return view('esrequests.create');
    }

    function store(CreateEsrequest $request)
    {
        $esrequest = new Esrequest($request->all());
        Auth::user()->esrequests()->save($esrequest);
        return redirect('esrequests');
    }
}

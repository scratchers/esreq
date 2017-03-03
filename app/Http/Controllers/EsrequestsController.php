<?php

namespace App\Http\Controllers;

use App\Esrequest;
use App\Http\Requests\CreateEsrequest;
use Illuminate\Http\Request;
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

        $esrequests->controller = 'EsrequestsController@show';

        return view('esrequests.index', compact('esrequests'));
    }

    function new()
    {
        $esrequests = Esrequest::whereNull('fulfilled_at')->get();

        $esrequests->controller = 'EsrequestsController@show';

        return view('esrequests.index', compact('esrequests'));
    }

    function show(Esrequest $esrequest)
    {
        return view('esrequests.show', compact('esrequest'));
    }

    function create()
    {
        return view('esrequests.create');
    }

    function store(CreateEsrequest $request)
    {
        $esrequest = new Esrequest($request->all());

        Auth::user()->esrequests()->save($esrequest);

        Mail::to(env('MAIL_FROM_ADDRESS', 'esreq@uark.edu'))
            ->send(new NewEsrequest($esrequest));

        flash('Request submitted.', 'success');

        return redirect('home');
    }
}

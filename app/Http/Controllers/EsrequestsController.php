<?php

namespace App\Http\Controllers;

use App\Esrequest;
use App\Http\Requests\CreateEsrequest;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Mail\{FulfillEsrequest,NewEsrequest};
use Illuminate\Support\Facades\Mail;

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

    function fulfill(Esrequest $esrequest, Request $request)
    {
        $esrequest->fulfilled_at = new Carbon;

        $esrequest->note = $request->input('note');

        $esrequest->save();

        Mail::to($esrequest->user()->get())
            ->cc(env('MAIL_FROM_ADDRESS', 'esreq@uark.edu'))
            ->send(new FulfillEsrequest($esrequest));

        flash('Request fulfilled.', 'success');

        return $this->show($esrequest);
    }
}

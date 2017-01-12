<?php

namespace App\Http\Controllers;

use App\Esrequest;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $esrequests = Auth::user()->esrequests()->get();
        return view('esrequests.index', compact('esrequests'));
    }

    public function show(Esrequest $esrequest)
    {
        if (Gate::denies('view-esrequest', $esrequest)) {
            return abort('403');
        }

        return app(EsrequestsController::class)->show($esrequest);
    }
}

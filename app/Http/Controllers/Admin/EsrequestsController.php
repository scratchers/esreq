<?php

namespace App\Http\Controllers\Admin;

use App\Esrequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use Carbon\Carbon;
use App\Mail\FulfillEsrequest;
use Illuminate\Support\Facades\Mail;

class EsrequestsController extends Controller
{
    /**
     * Creates Admin Esrequests Controller with authorization.
     *
     * @return EsrequestsController
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->authorize('administer', Esrequest::class);

            return $next($request);
        });

        View::share('route', 'admin.requests');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'esrequests' => Esrequest::with('user.institution')->get(),
        ];

        return view('esrequests.index', $data);
    }

    /**
     * Display a listing of the outstanding requests.
     *
     * @return \Illuminate\Http\Response
     */
    public function unfulfilled()
    {
        $data = [
            'esrequests' => Esrequest::with('user.institution')->whereNull('fulfilled_at')->get(),
            'h1' => 'New Requests',
        ];

        return view('esrequests.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Esrequest  $esrequest
     * @return \Illuminate\Http\Response
     */
    public function show(Esrequest $esrequest)
    {
        $data = [
            'esrequest' => $esrequest,
        ];

        return view('esrequests.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Esrequest  $esrequest
     * @return \Illuminate\Http\Response
     */
    public function edit(Esrequest $esrequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Esrequest  $esrequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Esrequest $esrequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Esrequest  $esrequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Esrequest $esrequest)
    {
        //
    }

    function fulfill(Esrequest $esrequest, Request $request)
    {
        $esrequest->fulfilled_at = new Carbon;

        $esrequest->note = $request->input('note');

        $esrequest->save();

        Mail::to($esrequest->user()->get())
            ->cc(config('mail.from.address'))
            ->send(new FulfillEsrequest($esrequest));

        flash('Request fulfilled.', 'success');

        return back();
    }
}

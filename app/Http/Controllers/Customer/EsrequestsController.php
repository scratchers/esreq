<?php

namespace App\Http\Controllers\Customer;

use App\Esrequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use View;

class EsrequestsController extends Controller
{
    /**
     * Creates Customer Esrequests Controller with authorization.
     *
     * @return EsrequestsController
     */
    public function __construct()
    {
        $this->authorizeResource(Esrequest::class);

        View::share('route', 'customer.requests');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'esrequests' => Auth::user()->esrequests,
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
}

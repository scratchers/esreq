<?php

namespace App\Http\Controllers\Customer;

use App\Esrequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Auth::user()->esrequests;
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
        return $esrequest;
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

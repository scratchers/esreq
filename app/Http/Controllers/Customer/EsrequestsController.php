<?php

namespace App\Http\Controllers\Customer;

use App\Esrequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use View;
use Mail;
use App\Http\Requests\CreateEsrequest;
use App\Mail\NewEsrequest;
use App\Platform;

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
        return view('esrequests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    function store(CreateEsrequest $request)
    {
        $esrequest = new Esrequest( $request->all() );

        $request->user()->esrequests()->save($esrequest);

        $platforms = Platform::find( $request->input('platform') );

        $esrequest->platforms()->sync($platforms);

        Mail::to(env('MAIL_FROM_ADDRESS', 'esreq@uark.edu'))
            ->send(new NewEsrequest($esrequest));

        flash('Request submitted.', 'success');

        return redirect(route('customer.requests.show', $esrequest));
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

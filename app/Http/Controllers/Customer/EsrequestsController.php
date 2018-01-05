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
use App\FacultyAccount;

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
            'esrequests' => Esrequest::with('user.institution')->where('user_id', Auth::user()->id)->get(),
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
        $facultyAccounts = FacultyAccount::with('platforms')
            ->where('user_id', Auth::user()->id)
            ->get();

        return view('esrequests.create', compact('facultyAccounts'));
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

        Mail::to(config('mail.from.address'))
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
     * Display the existing faculty accounts for the request's user.
     *
     * @param  \App\Esrequest  $esrequest
     * @return \Illuminate\Http\Response
     */
    public function facacc(Esrequest $esrequest)
    {
        $data = [
            'esrequest' => $esrequest,
        ];

        return view('esrequests.partials.facacc', $data);
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

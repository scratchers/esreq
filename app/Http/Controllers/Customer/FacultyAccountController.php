<?php

namespace App\Http\Controllers\Customer;

use App\FacultyAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FacultyAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facultyAccounts = FacultyAccount::mine()->with('platforms')->with('user')->get();

        return view('facultyAccounts.index', compact('facultyAccounts'));
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
     * @param  \App\FacultyAccount  $facultyAccount
     * @return \Illuminate\Http\Response
     */
    public function show(FacultyAccount $facultyAccount)
    {
        $this->authorize('view', $facultyAccount);
        return view('facultyAccounts.partials.show-modal', compact('facultyAccount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FacultyAccount  $facultyAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(FacultyAccount $facultyAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FacultyAccount  $facultyAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FacultyAccount $facultyAccount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FacultyAccount  $facultyAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(FacultyAccount $facultyAccount)
    {
        //
    }
}

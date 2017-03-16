<?php

namespace App\Http\Controllers;

use App\FacultyAccount;
use Illuminate\Http\Request;

class FacultyAccountController extends Controller
{
    /**
     * Creates Faculty Account Controller with authorization.
     *
     * @return FacultyAccountController
     */
    public function __construct()
    {
        $this->authorizeResource(FacultyAccount::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize(FacultyAccount::class);

        return FacultyAccount::with('user', 'platforms')->get();
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
        $facultyAccount->user;
        $facultyAccount->platforms;
        return $facultyAccount;
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

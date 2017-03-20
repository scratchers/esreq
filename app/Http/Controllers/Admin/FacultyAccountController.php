<?php

namespace App\Http\Controllers\Admin;

use App\FacultyAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class FacultyAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize(FacultyAccount::class);

        $facultyAccounts = FacultyAccount::with('user', 'platforms')->get();

        return view('facultyAccounts.index', compact('facultyAccounts'));
    }

    /**
     * Assigns a faculty account to a user.
     *
     * @return \Illuminate\Http\Response
     */
    public function assign(User $user)
    {
        $this->authorize(FacultyAccount::class);

        $facultyAccount = FacultyAccount::whereNull('user_id')->first();

        $user->facultyAccounts()->save($facultyAccount);

        return redirect(route('customer.facultyAccount.show', $facultyAccount));
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
        //
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

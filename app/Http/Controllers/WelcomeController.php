<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        return redirect(route('login'));
    }

    public function home()
    {
        return view('home');
    }

    public function instructions()
    {
        return view('instructions');
    }
}

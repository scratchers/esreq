<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App;

class AdminController extends Controller
{
    public function index()
    {
        if ( Auth::user()->isAdmin() ) {
            return view('admin');
        }

        return abort(403, 'Administrative Access Required');
    }

    public function impersonate(User $user)
    {
        if ( !Auth::user()->isAdmin() ) {
            return abort(403, 'Administrative Access Required');
        }

        if (App::Environment() !== 'local') {
            return abort(403, 'Impersonation is only available locally.');
        }

        Auth::login($user);
        return redirect(route('home'));
    }
}

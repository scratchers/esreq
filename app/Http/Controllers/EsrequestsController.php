<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Esrequest;

class EsrequestsController extends Controller
{
    function index()
    {
        $requests = Esrequest::all();
        return $requests;
    }
}

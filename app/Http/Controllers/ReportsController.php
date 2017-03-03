<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Esrequest;
use App\Institution;

class ReportsController extends Controller
{
    /**
     * Creates Reports Controller with authorization.
     *
     * @return ReportsController
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->authorize('report', Esrequest::class);

            return $next($request);
        });
    }

    /**
     * Display a summary of requests by institution.
     *
     * @return \Illuminate\Http\Response
     */
    public function institutions()
    {
        $institutions = Institution::all()->map(function($institution){
            $institution->requests = $institution->users->map(function($user){
                return $user->esrequests->count();
            })->sum();
            return $institution;
        });

        $data = [
            'columns' => [
                'name',
                'requests',
            ],
            'rows' => $institutions,
        ];

        return view('reports.index', $data);
    }
}

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
            $institution->link = route('reports.institutions.users', $institution);

            $institution->requests = $institution->users->map(function($user){
                return $user->esrequests->count();
            })->sum();

            return $institution;
        });

        $data = [
            'rows' => $institutions,
        ];

        return view('reports.index', $data);
    }

    /**
     * Display a summary of user requests from an institution.
     *
     * @return \Illuminate\Http\Response
     */
    public function institutionUsers(Institution $institution)
    {
        $users = $institution->users->map(function($user){
            $user->link = '';
            $user->requests = $user->esrequests->count();
            $user->name = "{$user->first_name} {$user->last_name}";
            return $user;
        });

        $data = [
            'rows' => $users,
            'breadcrumbs' => [
                ['text' => $institution->name],
            ],
        ];

        return view('reports.index', $data);
    }
}

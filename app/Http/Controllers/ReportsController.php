<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Esrequest;
use App\Institution;
use App\User;
use stdClass;

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
     * Display a list of reports.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $institutions = new stdClass;
        $institutions->name = 'Institutions';
        $institutions->link = route('report.institutions.index');
        $institutions->requests = Institution::all()->count();

        $users = new stdClass;
        $users->name = 'Users';
        $users->link = route('report.users.index');
        $users->requests = User::all()->count();

        $requests = new stdClass;
        $requests->name = 'Requests';
        $requests->link = route('report.requests.index');
        $requests->requests = Esrequest::all()->count();

        $reports = [
            $institutions,
            $users,
            $requests,
        ];

        $data = [
            'rows' => $reports,
            'breadcrumbs' => [
                ['text' => 'Institutions'],
            ],
        ];

        return view('report.index', $data);
    }

    /**
     * Display a summary of requests by institution.
     *
     * @return \Illuminate\Http\Response
     */
    public function institutions()
    {
        $institutions = Institution::all()->map(function($institution){
            $institution->link = route('report.institutions.show', $institution);

            $institution->requests = $institution->users->map(function($user){
                return $user->esrequests->count();
            })->sum();

            return $institution;
        });

        $data = [
            'rows' => $institutions,
            'breadcrumbs' => [
                ['text' => 'Institutions'],
            ],
        ];

        return view('report.index', $data);
    }

    /**
     * Display a summary of user requests from an institution.
     *
     * @return \Illuminate\Http\Response
     */
    public function institution(Institution $institution)
    {
        $users = $institution->users->map(function($user){
            $user->link = route('report.users.show', $user);
            $user->requests = $user->esrequests->count();
            $user->name = "{$user->first_name} {$user->last_name}";
            return $user;
        });

        $data = [
            'rows' => $users,
            'breadcrumbs' => [
                [
                    'text' => 'Institutions',
                    'link' => route('report.institutions.index'),
                ],
                ['text' => $institution->name],
            ],
        ];

        return view('report.index', $data);
    }

    /**
     * Display a summary of all user requests.
     *
     * @return \Illuminate\Http\Response
     */
    public function users()
    {
    }

    /**
     * Display a summary of a user's requests.
     *
     * @return \Illuminate\Http\Response
     */
    public function user(User $user)
    {
        $user->name = "{$user->first_name} {$user->last_name}";

        $data = [
            'rows' => $user->esrequests->map(function($request){
                $request->link = route('report.requests.show', $request);
                $request->name = $request->created_at;
                $request->requests = $request->faculty_accounts + $request->student_accounts;
                return $request;
            }),
            'breadcrumbs' => [
                [
                    'text' => 'Institutions',
                    'link' => route('report.institutions.index'),
                ],
                [
                    'text' => $user->institution->name,
                    'link' => route('report.institutions.show', $user->institution),
                ],
                ['text' => $user->name],
            ],
        ];

        return view('report.index', $data);
    }

    /**
     * Display a summary of all requests.
     *
     * @return \Illuminate\Http\Response
     */
    public function requests()
    {
    }

    /**
     * Show details of request.
     *
     * @return \Illuminate\Http\Response
     */
    public function request(Esrequest $esrequest)
    {
        $data = [
            'esrequest' => $esrequest,
            'breadcrumbs' => [
                [
                    'text' => 'Institutions',
                    'link' => route('report.institutions.index'),
                ],
                [
                    'text' => $esrequest->user->institution->name,
                    'link' => route('report.institutions.show', $esrequest->user->institution),
                ],
                [
                    'text' => "{$esrequest->user->first_name} {$esrequest->user->last_name}",
                    'link' => route('report.users.show', $esrequest->user),
                ],
                ['text' => $esrequest->created_at],
            ],
        ];

        return view('report.esrequest', $data);
    }
}

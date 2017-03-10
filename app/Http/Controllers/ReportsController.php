<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Esrequest;
use App\Institution;
use App\User;
use stdClass;
use DB;

class ReportsController extends Controller
{
    protected $joinPlatforms = "
        LEFT JOIN (
            SELECT e.id, faculty_accounts + student_accounts AS 'Accounts'
            FROM esrequests e
            JOIN esrequest_platform ep
                ON e.id = ep.esrequest_id
            JOIN platforms p
                ON ep.platform_id = p.id
            WHERE p.name = 'SAP'
        ) sap ON e.id = sap.id
        LEFT JOIN (
            SELECT e.id, faculty_accounts + student_accounts AS 'Accounts'
            FROM esrequests e
            JOIN esrequest_platform ep
                ON e.id = ep.esrequest_id
            JOIN platforms p
                ON ep.platform_id = p.id
            WHERE p.name = 'IBM'
        ) ibm ON e.id = ibm.id
        LEFT JOIN (
            SELECT e.id, faculty_accounts + student_accounts AS 'Accounts'
            FROM esrequests e
            JOIN esrequest_platform ep
                ON e.id = ep.esrequest_id
            JOIN platforms p
                ON ep.platform_id = p.id
            WHERE p.name = 'Teradata'
        ) teradata ON e.id = teradata.id
        LEFT JOIN (
            SELECT e.id, faculty_accounts + student_accounts AS 'Accounts'
            FROM esrequests e
            JOIN esrequest_platform ep
                ON e.id = ep.esrequest_id
            JOIN platforms p
                ON ep.platform_id = p.id
            WHERE p.name = 'Microsoft'
        ) microsoft ON e.id = microsoft.id
    ";

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
                ['text' => 'All'],
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
        $sql = "
            SELECT
                i.name AS 'Institution',
                i.id,
                COUNT(DISTINCT u.id) AS 'Users',
                COUNT(DISTINCT e.id) AS 'Requests',
                SUM(sap.Accounts) AS 'SAP',
                SUM(ibm.Accounts) AS 'IBM',
                SUM(teradata.Accounts) AS 'Teradata',
                SUM(microsoft.Accounts) AS 'Microsoft'
            FROM institutions i
            JOIN users u
              ON i.id = u.institution_id
            JOIN esrequests e
              ON u.id = e.user_id
            {$this->joinPlatforms}
            GROUP BY i.id, i.name
        ";

        $institutions = collect( DB::select( DB::raw($sql) ) )->map(function($institution){
            $institution->id = route('report.institutions.show', $institution->id);
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
        $sql = "
            SELECT
                CONCAT(u.first_name, ' ', u.last_name) AS 'User',
                u.id,
                COUNT(DISTINCT e.id) AS 'Requests',
                SUM(sap.Accounts) AS 'SAP',
                SUM(ibm.Accounts) AS 'IBM',
                SUM(teradata.Accounts) AS 'Teradata',
                SUM(microsoft.Accounts) AS 'Microsoft'
            FROM users u
            JOIN esrequests e
              ON u.id = e.user_id
            {$this->joinPlatforms}
            WHERE u.institution_id = {$institution->id}
            GROUP BY u.id, u.first_name, u.last_name
        ";

        $users = collect( DB::select( DB::raw($sql) ) )->map(function($user){
            $user->id = route('report.users.show', $user->id);
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
        $sql = "
            SELECT
                CONCAT(u.first_name, ' ', u.last_name) AS 'User',
                u.id,
                COUNT(DISTINCT e.id) AS 'Requests',
                SUM(sap.Accounts) AS 'SAP',
                SUM(ibm.Accounts) AS 'IBM',
                SUM(teradata.Accounts) AS 'Teradata',
                SUM(microsoft.Accounts) AS 'Microsoft'
            FROM users u
            JOIN esrequests e
              ON u.id = e.user_id
            {$this->joinPlatforms}
            GROUP BY u.id, u.first_name, u.last_name
        ";

        $users = collect( DB::select( DB::raw($sql) ) )->map(function($user){
            $user->id = route('report.users.show', $user->id);
            return $user;
        });

        $data = [
            'rows' => $users,
            'breadcrumbs' => [
                ['text' => 'Requests'],
            ],
        ];

        return view('report.index', $data);
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
            'name'  => 'Created',
            'count' => 'Accounts',
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
        $data = [
            'rows' => Esrequest::all()->map(function($request){
                $request->link = route('report.requests.show', $request);
                $request->name = $request->created_at;
                $request->requests = $request->faculty_accounts + $request->student_accounts;
                return $request;
            }),
            'name'  => 'Created',
            'count' => 'Accounts',
            'breadcrumbs' => [
                ['text' => 'Requests'],
            ],
        ];

        return view('report.index', $data);
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

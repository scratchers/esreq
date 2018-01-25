<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Esrequest;
use App\Institution;
use App\User;
use stdClass;
use DB;
use Response;
use InvalidArgumentException;

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
            WHERE p.name = 'IBM-TSO'
        ) ibmtso ON e.id = ibmtso.id
        LEFT JOIN (
            SELECT e.id, faculty_accounts + student_accounts AS 'Accounts'
            FROM esrequests e
            JOIN esrequest_platform ep
                ON e.id = ep.esrequest_id
            JOIN platforms p
                ON ep.platform_id = p.id
            WHERE p.name = 'IBM-zLinux'
        ) ibmzlin ON e.id = ibmzlin.id
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
        LEFT JOIN (
            SELECT e.id, faculty_accounts + student_accounts AS 'Accounts'
            FROM esrequests e
            JOIN esrequest_platform ep
                ON e.id = ep.esrequest_id
            JOIN platforms p
                ON ep.platform_id = p.id
            WHERE p.name = 'SAS'
        ) sas ON e.id = sas.id
    ";

    /**
     * Runs the SQL SELECT query and returns array result set
     * with any necessary date range conditions.
     *
     * @param  string $sql
     * @return array
     */
    protected function select(string $sql, Request $request) : array
    {
        if ( empty($dates = $this->getDateRange($request)) ) {
            return DB::select( DB::raw($sql) );
        }

        $sql = $this->appendWhereDateRangeCondition($sql, $dates);

        return DB::select( DB::raw($sql), $dates );
    }

    /**
     * Extracts the date range for the report.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array The date values [from,to] to bind to the query.
     */
    protected function getDateRange(Request $request) : array
    {
        if ( $request->has('dateFrom') ) {
            $dates['dateFrom'] = $request->input('dateFrom');
        }

        if ( $request->has('dateTo') ) {
            $dates['dateTo'] = $request->input('dateTo');
        }

        return $dates ?? [];
    }

    /**
     * Appends the date range where condition into the SQL SELECT query string.
     *
     * @param  string $sql
     * @return string
     */
    protected function appendWhereDateRangeCondition(string $sql, array $dates) : string
    {
        $wherePosition = strpos($sql, " GROUP BY ");

        if ( false === $wherePosition ) {
            throw new InvalidArgumentException("GROUP BY clause not found in: $sql");
        }

        $where = ' AND '.$this->getWhereDateRangeCondition($dates).PHP_EOL;

        $sql = substr_replace( $sql, $where, $wherePosition, 0 );

        return $sql;
    }

    /**
     * Creates the date range where condition.
     *
     * @param  array $dates
     * @return string
     */
    protected function getWhereDateRangeCondition(array $dates) : string
    {
        if ( empty($dates['dateFrom']) && empty($dates['dateTo']) ) {
            throw new InvalidArgumentException("dates array cannot be empty.");
        }

        if ( isset($dates['dateFrom']) && isset($dates['dateTo']) ) {
            return "e.created_at BETWEEN :dateFrom AND :dateTo";
        }

        if ( isset($dates['dateFrom']) ) {
            return "e.created_at >= :dateFrom";
        }

        return "e.created_at <= :dateTo";
    }

    /**
     * Send the response as a CSV download attachment.
     * http://stackoverflow.com/a/27596496/4233593
     *
     * @param  \Illuminate\Support\Collection DB result set
     * @return \Illuminate\Http\Response
     */
    protected function csv($data)
    {
        $data = $data->map(function($item){
            return (array)$item;
        })->toArray();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="report.csv"',
        ];

        // add headers for each column in the CSV download
        array_unshift($data, array_keys($data[0]));

        $callback = function() use ($data) {
            $FH = fopen('php://output', 'w');
            foreach ($data as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        return Response::stream($callback, 200, $headers);
    }

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
    public function index(Request $request)
    {
        $institutions = new stdClass;
        $institutions->name = 'Institutions';
        $institutions->id = route('report.institutions.index');
        $institutions->count = Institution::all()->count();

        $users = new stdClass;
        $users->name = 'Users';
        $users->id = route('report.users.index');
        $users->count = User::all()->count();

        $requests = new stdClass;
        $requests->name = 'Requests';
        $requests->id = route('report.requests.index');
        $requests->count = Esrequest::all()->count();

        $reports = collect([
            $institutions,
            $users,
            $requests,
        ]);

        if ( $request->has('csv') ) {
            return $this->csv($reports);
        }

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
    public function institutions(Request $request)
    {
        $sql = "
            SELECT
                i.name AS 'Institution',
                i.id,
                COUNT(DISTINCT u.id) AS 'Users',
                COUNT(DISTINCT e.id) AS 'Requests',
                SUM(sap.Accounts) AS 'SAP',
                SUM(ibmtso.Accounts) AS 'IBM-TSO',
                SUM(ibmzlin.Accounts) AS 'IBM-zLinux',
                SUM(teradata.Accounts) AS 'Teradata',
                SUM(sas.Accounts) AS 'SAS',
                SUM(microsoft.Accounts) AS 'Microsoft'
            FROM institutions i
            JOIN users u
              ON i.id = u.institution_id
            JOIN esrequests e
              ON u.id = e.user_id
            {$this->joinPlatforms}
            WHERE 1=1
            GROUP BY i.id, i.name
        ";

        $institutions = collect( $this->select($sql, $request) )->map(function($institution){
            $institution->id = route('report.institutions.show', $institution->id);
            return $institution;
        });

        if ( $request->has('csv') ) {
            return $this->csv($institutions);
        }

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
    public function institution(Request $request, Institution $institution)
    {
        $sql = "
            SELECT
                CONCAT(u.first_name, ' ', u.last_name) AS 'User',
                u.id,
                COUNT(DISTINCT e.id) AS 'Requests',
                SUM(sap.Accounts) AS 'SAP',
                SUM(ibmtso.Accounts) AS 'IBM-TSO',
                SUM(ibmzlin.Accounts) AS 'IBM-zLinux',
                SUM(teradata.Accounts) AS 'Teradata',
                SUM(sas.Accounts) AS 'SAS',
                SUM(microsoft.Accounts) AS 'Microsoft'
            FROM users u
            JOIN esrequests e
              ON u.id = e.user_id
            {$this->joinPlatforms}
            WHERE u.institution_id = {$institution->id}
            GROUP BY u.id, u.first_name, u.last_name
        ";

        $users = collect( $this->select($sql, $request) )->map(function($user){
            $user->id = route('report.users.show', $user->id);
            return $user;
        });

        if ( $request->has('csv') ) {
            return $this->csv($users);
        }

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
    public function users(Request $request)
    {
        $sql = "
            SELECT
                CONCAT(u.first_name, ' ', u.last_name) AS 'User',
                u.id,
                COUNT(DISTINCT e.id) AS 'Requests',
                SUM(sap.Accounts) AS 'SAP',
                SUM(ibmtso.Accounts) AS 'IBM-TSO',
                SUM(ibmzlin.Accounts) AS 'IBM-zLinux',
                SUM(teradata.Accounts) AS 'Teradata',
                SUM(sas.Accounts) AS 'SAS',
                SUM(microsoft.Accounts) AS 'Microsoft'
            FROM users u
            JOIN esrequests e
              ON u.id = e.user_id
            {$this->joinPlatforms}
            WHERE 1=1
            GROUP BY u.id, u.first_name, u.last_name
        ";

        $users = collect( $this->select($sql, $request) )->map(function($user){
            $user->id = route('report.users.show', $user->id);
            return $user;
        });

        if ( $request->has('csv') ) {
            return $this->csv($users);
        }

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
    public function user(Request $request, User $user)
    {
        $sql = "
            SELECT
                e.created_at AS 'Created',
                e.id,
                SUM(sap.Accounts) AS 'SAP',
                SUM(ibmtso.Accounts) AS 'IBM-TSO',
                SUM(ibmzlin.Accounts) AS 'IBM-zLinux',
                SUM(teradata.Accounts) AS 'Teradata',
                SUM(sas.Accounts) AS 'SAS',
                SUM(microsoft.Accounts) AS 'Microsoft'
            FROM esrequests e
            {$this->joinPlatforms}
            WHERE e.user_id = {$user->id}
            GROUP BY e.id, e.created_at
        ";

        $requests = collect( $this->select($sql, $request) )->map(function($request){
            $request->id = route('report.requests.show', $request->id);
            return $request;
        });

        if ( $request->has('csv') ) {
            return $this->csv($requests);
        }

        $data = [
            'rows' => $requests,
            'breadcrumbs' => [
                [
                    'text' => 'Institutions',
                    'link' => route('report.institutions.index'),
                ],
                [
                    'text' => $user->institution->name,
                    'link' => route('report.institutions.show', $user->institution),
                ],
                ['text' => "{$user->first_name} {$user->last_name}"],
            ],
        ];

        return view('report.index', $data);
    }

    /**
     * Display a summary of all requests.
     *
     * @return \Illuminate\Http\Response
     */
    public function requests(Request $request)
    {
        $sql = "
            SELECT
                e.created_at AS 'Created',
                e.id,
                SUM(sap.Accounts) AS 'SAP',
                SUM(ibmtso.Accounts) AS 'IBM-TSO',
                SUM(ibmzlin.Accounts) AS 'IBM-zLinux',
                SUM(teradata.Accounts) AS 'Teradata',
                SUM(sas.Accounts) AS 'SAS',
                SUM(microsoft.Accounts) AS 'Microsoft'
            FROM esrequests e
            {$this->joinPlatforms}
            WHERE 1=1
            GROUP BY e.id, e.created_at
        ";

        $requests = collect( $this->select($sql, $request) )->map(function($request){
            $request->id = route('report.requests.show', $request->id);
            return $request;
        });

        if ( $request->has('csv') ) {
            return $this->csv($requests);
        }

        $data = [
            'rows' => $requests,
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

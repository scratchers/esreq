<!doctype html><html><body>

<p>
    <a href="{{ route('customer.requests.show', $esrequest) }}">Your request for access</a>
    to Enterprise Systems
    from the department of Information Systems
    in the Sam M. Walton College of Business
    at the University of Arkansas
    in Fayetteville, Arkansas has been fulfilled.
</p>

<p>
    <table border=1>
        <tbody>
            @foreach($esrequest->getFields() as $key => $value)
                <tr>
                    <td>{{  $key  }}</td>
                    <td>{{ $value }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</p>

<p>
    Remote Access Instructions:
    <ul>
        <li>
            <a href="https://walton.uark.edu/enterprise/downloads/remote-access-external.pdf">
                External Users
            </a>
        </li>
        <li>
            <a href="https://walton.uark.edu/enterprise/downloads/remote-access-walton.pdf">
                Internal Users (Sam M. Walton College of Business only)
            </a>
        </li>
    </ul>
</p>

<div>
    <pre>{{ $esrequest->note }}</pre>
</div>

</body></html>

<a href="{{ url('/home/'.$esrequest->id) }}">Your request for access</a> to Enterprise Systems from the department of
Information Systems in the Sam M. Walton College of Business at
the University of Arkansas in Fayetteville, Arkansas has been fulfilled.

<br/>
<br/>

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

<br/>

{{ $esrequest->note }}

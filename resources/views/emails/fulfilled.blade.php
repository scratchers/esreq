<!doctype html><html><body>

<p>
    <a href="{{ url('/home/'.$esrequest->id) }}">Your request for access</a>
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
    Remote Desktop Connection Instructions:
    <ul>
    @foreach ( $esrequest->platforms() as $platform )
        @if ( !empty($esrequest->$platform) )
        <li>
            <a href="{{ url('/downloads/remote-desktop-'.$platform.'.pdf') }}">
                {{ $platform }}
            </a>
        </li>
        @endif
    @endforeach
    </ul>
</p>

<p>
    {{ $esrequest->note }}
</p>

</body></html>

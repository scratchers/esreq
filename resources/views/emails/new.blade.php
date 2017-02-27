<!doctype html><html><body>

<p>
    There is a
    <a href="{{ url('/admin/'.$esrequest->id) }}">new request</a>
    for access to Enterprise Systems.
</p>

<p>
    {{ $esrequest->user->first_name }} {{ $esrequest->user->last_name }}, {{ $esrequest->user->institution->name }}
    <br/>
    <a href="mailto:{{ $esrequest->user_email }}">{{ $esrequest->user_email }}</a>
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
    {{ $esrequest->user_comment }}
</p>

</body></html>

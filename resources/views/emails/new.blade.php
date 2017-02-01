<!doctype html><html><body>

<p>
    There is a
    <a href="{{ url('/admin/'.$esrequest->id) }}">new request</a>
    for access to Enterprise Systems from {{ $esrequest->userBriefs() }}.
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

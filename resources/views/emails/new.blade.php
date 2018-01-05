<!doctype html><html><body>

<p>
    There is a
    <a href="{{ route('admin.requests.show', $esrequest) }}">new request</a>
    for access to Enterprise Systems.
</p>

<p>
    {{ $esrequest->user->name }}
    <br/>
    <a href="mailto:{{ $esrequest->user->email }}">{{ $esrequest->user->email }}</a>
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

<div>
    {!! nl2br(e($esrequest->user_comment)) !!}
</div>

</body></html>

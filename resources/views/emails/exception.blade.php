<!doctype html><html><body>

<p>
    There was an exception thrown in {{ config('app.name') }}.
</p>

<h2>Exception</h2>

<pre>
    {{ $exception }}
</pre>

@unless(empty($validations))
    <h2>Validation</h2>
    <pre>{{ $validations }}</pre>
@endunless

<h2>Request</h2>

<pre>
    {{ $request }}
</pre>

<h2>User</h2>

<pre>
    {{ $user }}
</pre>

<h2>Server</h2>

<pre>
    {{ $server }}
</pre>

</body></html>

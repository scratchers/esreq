<!doctype html><html><body>

<p>
    There was an exception thrown in {{ config('app.name') }}.
</p>

<h2>Exception</h2>

<pre>
    {{ $exception }}
</pre>

<h2>Request</h2>

<pre>
    {{ $request }}
</pre>

<h2>User</h2>

<pre>
    {{ $user }}
</pre>

</body></html>

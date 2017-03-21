@extends('layouts.app')

@section('content')
<h1>Administration</h1>

<ul>
    <li>
        <a href="{{ route('admin.requests.unfulfilled') }}">
            New Requests
        </a>
    </li>

    <li>
        <a href="{{ route('admin.facultyAccount.index') }}">
            Faculty Accounts
        </a>
    </li>
</ul>

@endsection

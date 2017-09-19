@extends('layouts.app')

@section('content')
<h1>Home</h1>

<ul>
    <li>
        <a href="{{ route('customer.requests.index') }}">
            My Requests
        </a>
    </li>

    <li>
        <a href="{{ route('customer.facultyAccount.index') }}">
            My Faculty Accounts
        </a>
    </li>

    <li>
        <a href="{{ route('users.show', Auth::user()) }}">
            My Profile
        </a>
    </li>
</ul>

@endsection

@extends('layouts.app')

@section('content')
<h1>Home</h1>

<ul>
    <li><a href="{{ route('customer.requests.index') }}">Requests</a></li>
    <li><a href="{{ route('customer.facultyAccount.index') }}">Faculty Accounts</a></li>
    <li><a href="{{ route('users.show', Auth::user()) }}">Profile</a></li>
    <li><a href="{{ route('institutions.show', Auth::user()->institution) }}">Institution</a></li>
</ul>

@endsection

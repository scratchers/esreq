@extends('layouts.app')

@section('content')
<h1>Get Access to Enterprise Systems</h1>

@if (Auth::guest())
	<a href="{{ url('/register') }}" class="btn btn-success">Register</a> or
	<a href="{{ url('/login') }}" class="btn btn-primary">Login</a>
@endif

@endsection

@extends('layouts.app')

@section('content')
    <h1>{{ $user->first_name }} {{ $user->last_name }}</h1>

    <p><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>

    <p><a href="{{ route('institutions.show', $user->institution_id) }}">{{ $user->institution->name }}</a></p>
@endsection

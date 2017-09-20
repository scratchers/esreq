@extends('layouts.app')

@section('content')
    <div class="pull-right">
        <a href="{{ route('users.edit', $user) }}" class="btn btn-default">Edit <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
    </div>

    <h1>{{ $user->first_name }} {{ $user->last_name }}</h1>

    <p><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>

    <p><a href="{{ route('institutions.show', $user->institution_id) }}">{{ $user->institution->name }}</a></p>
@endsection

@extends('layouts.app')

@section('content')
    <div class="pull-right">
        <a href="{{ route('users.show', $user) }}" class="btn btn-warning">Cancel Editing <i class="fa fa-ban" aria-hidden="true"></i></a>
    </div>

    <form action="{{ route('users.update', $user) }}" method="post">
        {{ method_field('PUT') }}
        {{ csrf_field() }}

        <h1>
            <input type="text" name="first_name" value="{{ $user->first_name }}" placeholder="First Name" required>
            <input type="text" name="last_name" value="{{ $user->last_name }}" placeholder="Last Name" required>
        </h1>

        <p><input type="email" name="email" value="{{ $user->email }}" placeholder="Email" required></p>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection

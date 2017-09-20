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

        <div class="form-group">
            <select name="institution_id" style="width:50%">
                @foreach (App\Institution::all() as $institution)
                    <option value="{{ $institution->id }}" @if ($institution->id === $user->institution_id) selected @endif>{{ $institution->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection

@section('head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script type="text/javascript">
        $('select').select2();
    </script>
@endsection

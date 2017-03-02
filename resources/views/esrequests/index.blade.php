@extends('layouts.app')

@section('content')
    <h1>Requests</h1>

    <table class="datatable">
        <thead>
            <tr>
                <th>Details</th>
                <th>Created</th>
                @can('administer', Esrequest::class)
                    <th>Requestor</th>
                @endcan
                <th>Begins</th>
                <th>Fulfilled</th>
            </tr>
        </thead>

        <tbody>
            @foreach($esrequests as $esrequest)
                <tr>
                    <td><a href="{{ route("$route.show", $esrequest->id) }}" class="btn btn-primary">Details</a></td>
                    <td>{{ $esrequest->created_at }}</td>
                    @can('administer', Esrequest::class)
                        <td>{{ $esrequest->user->first_name }} {{ $esrequest->user->last_name }}, {{ $esrequest->user->institution->name }}</td>
                    @endcan
                    <td>{{ $esrequest->date_begin }}</td>
                    <td>{{ $esrequest->fulfilled_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

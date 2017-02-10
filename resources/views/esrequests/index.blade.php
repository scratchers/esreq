@extends('layouts.app')

@section('content')
    <h1>Requests</h1>

    @if (!empty($esrequests))
        <table class="datatable">
            <thead>
                <tr>
                    <th>Details</th>
                    <th>Created</th>
                    @if ( empty($esrequests->controller) )
                        <th>Requestor</th>
                    @endif
                    <th>Begins</th>
                    <th>Fulfilled</th>
                </tr>
            </thead>

            <tbody>
                @foreach($esrequests as $esrequest)
                    <tr>
                        <td><a href="{{ action($esrequests->controller ?? 'EsrequestsController@show', $esrequest->id) }}" class="btn btn-primary">Details</a></td>
                        <td>{{ $esrequest->created_at }}</td>
                        @if ( empty($esrequests->controller) )

                            <td>{{ $esrequest->user->first_name }} {{ $esrequest->user->last_name }}, {{ $esrequest->user->institution->name }}</td>

                        @endif
                        <td>{{ $esrequest->date_begin }}</td>
                        <td>{{ $esrequest->fulfilled_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No requests.</p>
    @endif
@endsection

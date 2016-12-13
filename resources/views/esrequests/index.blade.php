@extends('layouts.app')

@section('content')
    <h1>Enterprise Systems Requests</h1>

    @if (!empty($esrequests))
        <table class="datatable">
            <thead>
                <tr>
                    @foreach($fields as $field)
                        <th>{{ $field }}</th>
                    @endforeach
                </tr>
            </thead>

            <tbody>
                @foreach($esrequests as $esrequest)
                    <tr>
                        @foreach($fields as $field)
                            <td>{{ $esrequest->$field }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No requests.</p>
    @endif
@endsection

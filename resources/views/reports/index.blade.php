@extends('layouts.app')

@section('content')
    <h1>{{ $h1 or 'Requests' }}</h1>

    <table class="datatable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Requests</th>
            </tr>
        </thead>

        <tbody>
            @foreach ( $rows as $row )
                <tr>
                    <td><a href="{{ $row->link }}">{{ $row->name }}</a></td>
                    <td>{{ $row->requests }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

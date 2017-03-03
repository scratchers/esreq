@extends('layouts.app')

@section('content')
    <h1>{{ $h1 or 'Requests' }}</h1>

    <table class="datatable">
        <thead>
            <tr>
                @foreach ( $columns as $column )
                    <th>{{ $column }}</th>
                @endforeach
            </tr>
        </thead>

        <tbody>
            @foreach ( $rows as $row )
                <tr>
                    @foreach ( $columns as $column )
                        <td>{{ $row->$column }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

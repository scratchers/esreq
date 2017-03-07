@extends('layouts.app')

@section('content')
    <h1>{{ $h1 or 'Requests' }}</h1>

    @include('report.partials.breadcrumb')

    <table class="datatable">
        <thead>
            <tr>
                <th>{{ $name or 'Name' }}</th>
                <th>{{ $count or 'Count' }}</th>
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

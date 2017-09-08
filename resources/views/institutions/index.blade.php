@extends('layouts.app')

@section('content')
    <h1>Institutions</h1>

    <table class="datatable">
        <thead>
            <tr>
                <th>Name</th>
                <th>URL</th>
            </tr>
        </thead>

        <tbody>
            @foreach($institutions as $institution)
                <tr>
                    <td><a href="{{ route('institutions.show', $institution) }}">{{ $institution->name }}</a></td>
                    <td><a href="{{ $institution->url }}">{{ $institution->url }}</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

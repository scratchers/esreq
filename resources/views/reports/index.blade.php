@extends('layouts.app')

@section('content')
    <h1>{{ $h1 or 'Requests' }}</h1>

    <ol class="breadcrumb">
        <li><a href="{{ route('reports.institutions') }}">Institutions</a></li>
        @unless ( empty($breadcrumbs) )
        @foreach ( $breadcrumbs as $breadcrumb )
            @unless ( empty($breadcrumb['link']) )
                <li><a href="{{ $breadcrumb['link'] }}">{{ $breadcrumb['text'] }}</a></li>
            @else
                <li class="active">{{ $breadcrumb['text'] }}</li>
            @endunless
        @endforeach
        @endunless
    </ol>

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

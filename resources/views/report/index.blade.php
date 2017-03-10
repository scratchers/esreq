@extends('layouts.app')

@section('content')
    <h1>{{ $h1 or 'Requests' }}</h1>

    @include('report.partials.breadcrumb')

    <table class="datatable">
        <thead>
            <tr>
                @foreach ( $rows->first() as $key => $value )
                    @unless ( $key === 'id' )
                        <th>{{ $key }}</th>
                    @endunless
                @endforeach
            </tr>
        </thead>

        <tbody>
            @foreach ( $rows as $row )
                <tr>
                    @foreach ( $row as $column => $value )
                        @unless ( $column === 'id' )
                            @if ( $loop->first )
                                <td><a href="{{ $row->id }}">{{ $value }}</a></td>
                            @else
                                <td>{{ $value }}</td>
                            @endif
                        @endunless
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

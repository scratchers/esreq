@extends('layouts.app')

@section('content')
    <h1>{{ $h1 or 'Requests' }}</h1>

    @include('report.partials.breadcrumb')

    @include('esrequests.partials.esrequest')
@endsection

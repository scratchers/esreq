@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li><a href="/">Welcome</a></li>
        <li><a href='{{ route("$route.index") }}'>Requests</a></li>
        <li class="active">{{ $esrequest->id }}</li>
    </ol>

    <h1>Request Details</h1>

    @include('esrequests.partials.esrequest')
@endsection

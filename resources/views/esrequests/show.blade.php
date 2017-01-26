@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li><a href="/">Welcome</a></li>
        <li><a href="{{ substr(url()->current(), 0, strrpos( url()->current(), '/') ) }}">Requests</a></li>
        <li class="active">{{ $esrequest->id }}</li>
    </ol>

    <h1>Request Details</h1>

    <p class="lead">{{ $esrequest->userBriefs() }}</p>

    <div class="well">
    @foreach($esrequest->getFields() as $key => $value)
        <div class="row row-striped">
            <div class="col-xs-12 col-md-2 text-md-right"><strong>{{ $key }}</strong></div>
            <div class="col-xs-12 col-md-10">{{ $value }}</div>
        </div>
    @endforeach
    </div>

    @if ( strpos( url()->current(), '/admin/') !== false )
        @include('esrequests.fulfill-inc')
    @else
        {{ $esrequest->note }}
    @endif
@endsection

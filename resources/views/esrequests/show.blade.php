@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
        <li><a href="/">Welcome</a></li>
        <li><a href="{{ substr(url()->current(), 0, strrpos( url()->current(), '/') ) }}">Requests</a></li>
        <li class="active">{{ $esrequest->id }}</li>
    </ol>

    <h1>Request Details</h1>

    <p class="lead">
        {{ $esrequest->user_fullname }}, {{ $esrequest->user_institution }}
        <br/>
        <a href="mailto:{{ $esrequest->user_email }}">{{ $esrequest->user_email }}</a>
    </p>

    <div class="well">
    @foreach($esrequest->getFields() as $key => $value)
        <div class="row row-striped">
            <div class="col-xs-12 col-md-2 text-md-right"><strong>{{ $key }}</strong></div>
            <div class="col-xs-12 col-md-10">{{ $value }}</div>
        </div>
    @endforeach
    </div>

    @unless ( empty($esrequest->user_comment) )
    <h2>User Comment</h2>
    <div class="well">
        <p>{{ $esrequest->user_comment }}</p>
    </div>
    @endunless

    @if ( strpos( url()->current(), '/admin/') !== false )
        @include('esrequests.fulfill-inc')
    @else
        @unless ( empty($esrequest->note) )
        <h2>Admin Response</h2>
        <div class="well">
            <p>{{ $esrequest->note }}</p>
        </div>
        @endunless
    @endif
@endsection

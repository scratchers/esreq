@extends('layouts.app')

@section('content')
    <h1>{{ $institution->name }}</h1>
    <p><a href="{{ $institution->url }}">{{ $institution->url }}</a></p>

    @unless (empty($institution->latitude))
    <p>Location: {{ $institution->latitude}}, {{$institution->longitude }}</p>
    @endunless
@endsection

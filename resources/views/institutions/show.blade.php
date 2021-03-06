@extends('layouts.app')

@section('content')
    <div class="pull-right">
        <a href="{{ route('institutions.index') }}" class="btn btn-default">All Institutions</a>

        @can ('update', $institution)
        <a href="{{ route('institutions.edit', $institution) }}" class="btn btn-default">Edit <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
        @endcan
    </div>

    <h1>{{ $institution->name }}</h1>

    <p><a href="{{ $institution->url }}">{{ $institution->url }}</a></p>

    @unless (empty($institution->latitude))
        <div class="panel panel-default">
            <div class="panel-body">
                <div id="map" style="height:800px"></div>
            </div>
        </div>
    @endunless
@endsection

@push('scripts')
    @unless (empty($institution->latitude))
    <script>
    var map, marker;

    function initMap()
    {
        var location = {lat: {{ $institution->latitude }}, lng: {{ $institution->longitude }}};

        map = new google.maps.Map(document.getElementById('map'), {
            center: location,
            zoom: 5,
        });

        marker = new google.maps.Marker({
            position: location,
            map: map,
            title: "{{ $institution->name }}",
        });
    }
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?v=3&callback=initMap&key={{ config('google-maps.client-key') }}">
    </script>
    @endunless
@endpush

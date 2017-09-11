@extends('layouts.app')

@section('content')
    <h1>{{ $institution->name }}</h1>
    <p><a href="{{ $institution->url }}">{{ $institution->url }}</a></p>

    @unless (empty($institution->latitude))
    <p>Location: {{ $institution->latitude}}, {{$institution->longitude }}</p>
    @endunless

    <div id="map" style="height:800px"></div>
@endsection

@push('scripts')
    <script>
    var map;

    function initMap() {
        var arkansas = {lat: 35.998093, lng: -94.089991};
        map = new google.maps.Map(document.getElementById('map'), {
          center: arkansas,
          zoom: 13
        });
    }
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ config('google-maps.key') }}&callback=initMap">
    </script>
@endpush

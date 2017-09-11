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

    function initMap()
    {
        var wcob = {lat: 36.06463197792664, lng: -94.17427137166595};
        map = new google.maps.Map(document.getElementById('map'), {
            center: wcob,
            zoom: 13
        });

        var marker = new google.maps.Marker({
            position: wcob,
            map: map,
            draggable: true,
            title: "Drag me!"
        });

        google.maps.event.addListener(marker, 'dragend', function (evt) {
            console.log('lat: ' + evt.latLng.lat() + ' lng: ' + evt.latLng.lng());
        });
    }
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ config('google-maps.key') }}&callback=initMap">
    </script>
@endpush

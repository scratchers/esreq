@extends('layouts.app')

@section('content')
    <h1>{{ $institution->name }}</h1>
    <p><a href="{{ $institution->url }}">{{ $institution->url }}</a></p>

    @unless (empty($institution->latitude))
        <div id="map" style="height:800px"></div>
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
            zoom: 13,
        });

        marker = new google.maps.Marker({
            position: location,
            map: map,
            title: "{{ $institution->name }}",
        });
    }
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?v=3&callback=initMap&key={{ config('google-maps.key') }}">
    </script>
    @endunless
@endpush

@extends('layouts.app')

@section('content')
    <div class="pull-right">
        <a href="{{ route('institutions.index') }}" class="btn btn-default">All Institutions</a>
        <a href="{{ route('institutions.show', $institution) }}" class="btn btn-warning">Cancel Editing</a>
    </div>

    <form action="{{ route('institutions.update', $institution) }}" method="post">
        {{ method_field('PUT') }}
        {{ csrf_field() }}

        <input type="hidden" name="latitude" value="{{ $institution->latitude }}">
        <input type="hidden" name="longitude" value="{{ $institution->longitude }}">

        <h1><input type="text" name="name" value="{{ $institution->name }}" required></h1>

        <p><input type="text" name="url" value="{{ $institution->url }}" required></p>

        <div class="panel panel-default">
            <div class="panel-body">
                <p>
                    Drag and drop the position marker
                    to show the institution's location.
                </p>
                <div id="map" style="height:800px"></div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>

@endsection

@push('scripts')
    <script>
    var map, marker;

    function initMap()
    {
        var location = {lat: {{ $institution->latitude or 36.06463197792664 }}, lng: {{ $institution->longitude or -94.17427137166595 }}};

        map = new google.maps.Map(document.getElementById('map'), {
            center: location,
            zoom: 5,
        });

        marker = new google.maps.Marker({
            position: location,
            map: map,
            draggable: true,
            title: "Drag me!",
        });

        google.maps.event.addListener(marker, 'dragend', function(){
            $('input[name=latitude]').val(marker.position.lat());
            $('input[name=longitude]').val(marker.position.lng());
        });
    }
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?v=3&callback=initMap&key={{ config('google-maps.key') }}">
    </script>
@endpush

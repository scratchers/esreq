@extends('layouts.app')

@section('content')
<div class="pull-right">
    <a href="{{ route('institutions.index') }}" class="btn btn-default">All Institutions</a>
    <a href="{{ url()->previous() }}" class="btn btn-warning">Cancel</a>
</div>

<h1>Create Institution</h1>

<form class="form-horizontal" role="form" method="POST" action="{{ route('institutions.store') }}">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label for="name" class="col-md-1 control-label">Name</label>
        <div class="col-md-6">
            <input name="name" id="name" class="form-control" value="{{ old('name') }}" required>

            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
        <label for="url" class="col-md-1 control-label">Website</label>
        <div class="col-md-6">
            <input name="url" id="url" class="form-control" value="{{ old('url') ?: 'https://' }}" type="url" required>

            @if ($errors->has('url'))
                <span class="help-block">
                    <strong>{{ $errors->first('url') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <input type="hidden" name="latitude" value="{{ old('latitude') }}">
    <input type="hidden" name="longitude" value="{{ old('longitude') }}">
    <div class="panel panel-default">
        <div class="panel-body">
            <p>
                Drag and drop the position marker
                to show the institution's location.
            </p>
            <div id="map" style="height:800px"></div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">
        Submit
    </button>
</form>
@endsection

@push('scripts')
    <script>
    var map, marker;

    function initMap()
    {
        var location = {lat: {{ old('latitude', 36.06463197792664) }}, lng: {{ old('longitude', -94.17427137166595) }}};

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

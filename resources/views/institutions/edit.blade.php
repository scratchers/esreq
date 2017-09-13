@extends('layouts.app')

@section('content')
    <div class="pull-right">
        <a href="{{ route('institutions.index') }}" class="btn btn-default">All Institutions</a>
        <a href="{{ route('institutions.show', $institution) }}" class="btn btn-warning">Cancel Editing</a>
    </div>

    <h1>{{ $institution->name }}</h1>

    <p><a href="{{ $institution->url }}">{{ $institution->url }}</a></p>

    @unless (empty($institution->latitude))
    <p>Location: {{ $institution->latitude }}, {{ $institution->longitude }}</p>
    @endunless

    <div class="panel panel-default">
        <div class="panel-body">
            <p>
                Drag and drop the position marker
                to show the institution's location.
                Then click the save button.
            </p>
            <div id="map" style="height:800px"></div>
        </div>
        <div class="panel-footer">
            <button onclick="saveLocation()" class="btn btn-primary">
                Save
            </button>
        </div>
    </div>
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
    }

    function saveLocation()
    {
        $.ajax({
            type: "PATCH",
            url: "{{ route('institutions.update', $institution) }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "latitude": marker.position.lat(),
                "longitude": marker.position.lng(),
            },
            success: function (data) {
                $('#saveLocationConfirmation').modal();
            }
        });
    }
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?v=3&callback=initMap&key={{ config('google-maps.key') }}">
    </script>

    <div class="modal fade" id="saveLocationConfirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
              The institution has been updated successfully!
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
          </div>
        </div>
      </div>
    </div>
@endpush

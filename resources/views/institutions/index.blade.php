@extends('layouts.app')

@section('content')
    <h1>Institutions</h1>

    <div class="panel panel-default">
        <div class="panel-body">
            <div id="map" style="height:800px"></div>
        </div>
    </div>

    <table class="datatable">
        <thead>
            <tr>
                <th>Name</th>
                <th>URL</th>
            </tr>
        </thead>

        <tbody>
            @foreach($institutions as $institution)
                <tr>
                    <td><a href="{{ route('institutions.show', $institution) }}">{{ $institution->name }}</a></td>
                    <td><a href="{{ $institution->url }}">{{ $institution->url }}</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@push('scripts')
    <script>
    var map;

    function initMap()
    {
        var infoWindow = new google.maps.InfoWindow;

        var wcob = {lat: 36.06463197792664, lng: -94.17427137166595};

        map = new google.maps.Map(document.getElementById('map'), {
            center: wcob,
            zoom: 2,
        });

        var circle = {
            path: google.maps.SymbolPath.CIRCLE,
            fillColor: 'red',
            fillOpacity: .4,
            scale: 4.5,
            strokeColor: 'white',
            strokeWeight: 1
        };

        $.ajax({
            url: "{{ route('institutions.index') }}",
            headers: {
                'Accept':'application/json',
            },
            success: function (data) {
                $.each(data, function(index, institution){
                    if (institution.latitude) {
                        var marker = new google.maps.Marker({
                            position: {lat: institution.latitude, lng: institution.longitude},
                            map: map,
                            icon: circle,
                            title: institution.name,
                        });

                        var infowincontent = document.createElement('div');
                        infowincontent.innerHTML = '<a href="/institutions/'+ institution.id +'">'+ institution.name +'</a>';

                        marker.addListener('click', function() {
                            infoWindow.setContent(infowincontent);
                            infoWindow.open(map, marker);
                        });
                    }
                });
            }
        });
    }
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?v=3&callback=initMap&key={{ config('google-maps.key') }}">
    </script>
@endpush

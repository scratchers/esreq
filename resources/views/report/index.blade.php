@extends('layouts.app')

<?php $query = http_build_query($_GET); ?>

@section('content')

<h1>{{ $h1 or 'Reports' }}</h1>

<p class="lead">
    Note drilling down into request counts varies from entity counts
    because not all users have made a request.
</p>

@include('report.partials.breadcrumb')

@unless( Route::is('report') )
<div style="padding-bottom:15px">
    <form>
        <label for="dateFrom">Date From</label>
        <input type="text" id="dateFrom" name="dateFrom" value="{{ $_GET['dateFrom'] ?? '' }}">
        <label for="dateTo">to</label>
        <input type="text" id="dateTo" name="dateTo" value="{{ $_GET['dateTo'] ?? '' }}">
        <button type="submit" class="btn btn-primary">Filter by Date Range</button>
        <a href="{{ url()->current() }}" class="btn btn-default">Clear Date Range</a>
    </form>
</div>
@endunless

@unless ( $rows->isEmpty() )
    <table class="datatable-report">
        <thead>
            <tr>
                @foreach ( $rows->first() ?? [] as $key => $value )
                    @unless ( $key === 'id' )
                        <th>{{ $key }}</th>
                    @endunless
                @endforeach
            </tr>
        </thead>

        <tfoot>
            <tr>
                @foreach ( $rows->first() ?? [] as $key => $value )
                    @unless ( $key === 'id' )
                        <th></th>
                    @endunless
                @endforeach
            </tr>
        </tfoot>

        <tbody>
            @foreach ( $rows as $row )
                <tr>
                    @foreach ( $row as $column => $value )
                        @unless ( $column === 'id' )
                            @if ( $loop->first )
                                <td><a href="{{ $row->id }}?{{ $query }}">{{ $value }}</a></td>
                            @else
                                <td>{{ $value }}</td>
                            @endif
                        @endunless
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@endunless

<div style="padding:5px">
    <a href="?csv=1&{{ $query }}" class="btn btn-success">
        <i class="fa fa-table" aria-hidden="true"></i>
        Download CSV
    </a>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {

    @unless ( $rows->isEmpty() )
    $('.datatable-report').DataTable({
        'initComplete': function(){
            this.api().columns().every(function(col){
                if ( col > 0 ) {
                    var column = this;

                    var sum = column
                        .data()
                        .reduce(function (a, b) {
                            a = parseInt(a, 10);
                            if(isNaN(a)){ a = 0; }

                            b = parseInt(b, 10);
                            if(isNaN(b)){ b = 0; }

                            return a + b;
                        });

                    $(column.footer()).html(sum);
                }
            });
        }
    });
    @endunless

    var dateFormat = "yy-mm-dd",
        from = $( "#dateFrom" )
            .datepicker({
                dateFormat: "yy-mm-dd",
                defaultDate: "+1w",
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 3
            })
            .on( "change", function() {
                to.datepicker( "option", "minDate", getDate( this ) );
            }),
        to = $( "#dateTo" ).datepicker({
                dateFormat: "yy-mm-dd",
                defaultDate: "+1w",
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 3
            })
            .on( "change", function() {
                from.datepicker( "option", "maxDate", getDate( this ) );
            });

    function getDate( element ) {
        var date;

        try {
            date = $.datepicker.parseDate( dateFormat, element.value );
        } catch( error ) {
            date = null;
        }

        return date;
    }
});
</script>
@endpush

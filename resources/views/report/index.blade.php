@extends('layouts.app')

@section('content')
    <h1>{{ $h1 or 'Requests' }}</h1>

    @include('report.partials.breadcrumb')

    <div style="padding:5px">
        <a href="?csv=1" class="btn btn-success">
            <i class="fa fa-table" aria-hidden="true"></i>
            Download CSV
        </a>
    </div>

    <table class="datatable datatable-report">
        <thead>
            <tr>
                @foreach ( $rows->first() as $key => $value )
                    @unless ( $key === 'id' )
                        <th>{{ $key }}</th>
                    @endunless
                @endforeach
            </tr>
        </thead>

        <tfoot>
            <tr>
                @foreach ( $rows->first() as $key => $value )
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
                                <td><a href="{{ $row->id }}">{{ $value }}</a></td>
                            @else
                                <td>{{ $value }}</td>
                            @endif
                        @endunless
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

<script>
$(document).ready(function() {
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
});
</script>
@endsection

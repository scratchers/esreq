@extends('razorbacks::layout')

@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css"></link>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="/css/uark.css?03692d53291cb2ba0dba9e4936874e2d">
@endsection

@section('navbar')
    @auth
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('customer.requests.create') }}">New</a></li>
    @else
        <li><a href="{{ route('register') }}">Register</a></li>
    @endauth
    <li><a href="{{ route('instructions') }}">Instructions</a></li>
@endsection

@section('navbar-right')
    @auth
        @can('report', Esrequest::class)
            <li><a href="{{ route('report') }}">Reports</a></li>
        @endcan
        @can('administer', Esrequest::class)
            <li><a href="{{ route('admin') }}">Admin</a></li>
        @endcan
        <li>
            <a href="{{ url('/logout') }}">
                Logout {{ Auth::user()->first_name }}
            </a>
        </li>
    @else
        <li><a href="{{ route('login') }}">Login</a></li>
    @endauth
@endsection

@include('flash::message')

@section('scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
        crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function(){
            $('.datatable').DataTable();
        });

        function showAjaxModal(a){
            $.ajax({
                type: "GET",
                url: $(a).attr('href'),
                success: function (data) {
                    $('#myModal .modal-content').html(data);
                    $('#myModal').modal();
                    @unless ( empty($esrequest) )
                    $.ajax({
                        type: "GET",
                        url: "{{ route('customer.requests.facacc', $esrequest) }}",
                        success: function (data) {
                            $('#esrequests-partials-facacc').html(data);
                        }
                    });
                    @endunless
                }
            });
            return false;
        }
    </script>

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
@endsection

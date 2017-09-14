@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">University of Arkansas Users</div>
            <div class="panel-body">
                <p>
                    If you're a member of the University of Arkansas, then there's no need to register.
                    Just login with your UARK credentials using campus central authentication.
                </p>
                <div>
                    <a href="{{ route('shibboleth-login') }}" class="btn btn-primary">Login</a>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">External Users</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('institutions.create') }}">
                    {{ csrf_field() }}

                    <input name="institution_id" id="institution_id" type="hidden">
                    <div class="form-group{{ $errors->has('institution') ? ' has-error' : '' }}">
                        <label for="institution" class="col-md-4 control-label">Institution:</label>
                        <div class="col-md-6">
                            <input name="institution" id="institution" class="form-control" value="{{ old('institution') }}" required autofocus>

                            @if ($errors->has('institution'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('institution') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Register
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
    $( function() {
        $( "#institution" ).autocomplete({
            source: [
                @foreach (App\Institution::get() as $institution)
                { label: "{{ $institution->name }}", id: {{ $institution->id }} },
                @endforeach
            ],
            select: function( event, ui ) {
                $( "#institution" ).val(  ui.item.label  ).attr( "readonly", true );
                $( "#institution_id"  ).val( ui.item.id );
                return false;
            }
        });
    } );
    </script>
@endpush

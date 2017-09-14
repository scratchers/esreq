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
            <div class="panel-heading">External Users Register</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
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
                    <div class="form-group{{ $errors->has('institution_url') ? ' has-error' : '' }}">
                        <label for="institution_url" class="col-md-4 control-label">Institution Website:</label>
                        <div class="col-md-6">
                            <input name="institution_url" id="institution_url" class="form-control" value="{{ old('institution_url') ?: 'https://' }}" type="url" required autofocus>

                            @if ($errors->has('institution_url'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('institution_url') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <label for="first_name" class="col-md-4 control-label">First Name</label>

                        <div class="col-md-6">
                            <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus>

                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                        <label for="last_name" class="col-md-4 control-label">Last Name</label>

                        <div class="col-md-6">
                            <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required autofocus>

                            @if ($errors->has('last_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Password</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
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
                { label: "{{ $institution->name }}", id: {{ $institution->id }}, url: "{{ $institution->url }}" },
                @endforeach
            ],
            select: function( event, ui ) {
                $( "#institution" ).val(  ui.item.label  ).attr( "readonly", true );
                $( "#institution_url" ).val( ui.item.url ).attr( "readonly", true );
                $( "#institution_id"  ).val( ui.item.id );
                return false;
            }
        });
    } );
    </script>
@endpush

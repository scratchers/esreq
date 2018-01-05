@extends('layouts.app')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<h1>Create Request</h1>

{!! Form::open(['class'=>'form-horizontal', 'route'=>'customer.requests.store']) !!}
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Which platforms do you want to access?</h3>
  </div>

  <div class="panel-body">

    @foreach ( App\Platform::all() as $platform )
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('platform[]', $platform->id) !!}
                        {{ $platform->name }}
                    </label>

                    @if ( $platform->name === 'SAP' )
                        <div class="alert alert-warning" role="alert">
                            Must be an <a href="https://go.sap.com/training-certification/university-alliances.html" target="_blank">SAP University Alliances</a> member.
                        </div>
                    @elseif ( $platform->name === 'SAS' )
                        <div class="alert alert-warning" role="alert">
                            If you're requesting student accounts for SAS,
                            then please provide their usernames in the
                            <a href="#comment-section">comment section</a>.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
  </div>
</div>

@unless ( Auth::user()->facultyAccounts->isEmpty() )
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Here are your existing faculty accounts:</h3>
  </div>

  <div class="panel-body">
    <p>Click on username for more details:</p>
    <ul>
        @foreach ( Auth::user()->facultyAccounts as $facultyAccount )
            <li>
                <a
                    href="{{ route('customer.facultyAccount.show', $facultyAccount) }}"
                    onclick="return showAjaxModal(this)"
                >
                    {{ $facultyAccount->username }}
                </a>
                @foreach ( $facultyAccount->platforms as $platform )
                    <label class="label label-{{ $platform->name }}">
                        {{ $platform->name }}
                    </label>
                @endforeach
            </li>
        @endforeach
    </ul>
  </div>
</div>
@endunless

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">How many new accounts would you like?</h3>
  </div>

  <div class="panel-body">
    <div class="form-group">
        <label for="faculty_accounts" class="control-label col-sm-2">
            <input
                type="checkbox"
                onclick="$('#faculty_accounts').toggle()"
                {{ old('faculty_accounts') ? 'checked' : '' }}
            >
            Faculty:
        </label>
        <div class="col-sm-10">
            <input
                id="faculty_accounts"
                class="form-control"
                min="0"
                name="faculty_accounts"
                type="number"
                style="{{ old('faculty_accounts') ? '' : 'display:none' }}"
                value="{{ old('faculty_accounts') }}"
            >
        </div>
    </div>

    <div class="form-group">
        <label for="student_accounts" class="control-label col-sm-2">
            <input
                type="checkbox"
                onclick="$('#student_accounts').toggle()"
                {{ old('student_accounts') ? 'checked' : '' }}
            >
            Student:
        </label>
        <div class="col-sm-10">
            <input
                id="student_accounts"
                class="form-control"
                min="0"
                name="student_accounts"
                type="number"
                style="{{ old('student_accounts') ? '' : 'display:none' }}"
                value="{{ old('student_accounts') }}"
            >
        </div>
    </div>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">If you're using these accounts for a class, then please tell us about it.</h3>
  </div>

  <div class="panel-body">
    <div class="form-group">
        {!! Form::label('course_name', 'Course Name:', ['class'=>'control-label col-sm-2']) !!}
        <div class="col-sm-10">
            {!! Form::text('course_name', null, ['class'=>'form-control']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('date_begin', 'Start Date:', ['class'=>'control-label col-sm-2']) !!}
        <div class="col-sm-10">
            {!! Form::text('date_begin', null, ['class'=>'form-control datepicker']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('date_end', 'End Date:', ['class'=>'control-label col-sm-2']) !!}
        <div class="col-sm-10">
            {!! Form::text('date_end', null, ['class'=>'form-control datepicker']) !!}
        </div>
    </div>
    <div class="alert alert-warning" role="alert">
        If no end date is provided, then accounts are subject to deletion after 90 days.
    </div>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 id="comment-section" class="panel-title">Anything else you would like us to know?</h3>
  </div>

  <div class="panel-body">
    {!! Form::textarea('user_comment', null, ['class'=>'form-control']) !!}
  </div>
</div>

<div class="well">
    <p>
    <strong>NOTE:</strong> This agreement does not allow a user to copy any data on any computer system; data is to be used used for the classroom, research, development, and analysis purposes. Anyone who uses selected parts of this data agrees to delete all data and references from all computer systems. The <a href="/MUTUAL-CONFIDENTIALITY-AND-NONDISCLOSURE-AGREEMENT.html" target="_blank">MUTUAL CONFIDENTIALITY AND NONDISCLOSURE AGREEMENT</a> (which you are now a part of) does allow faculty to use results for classroom and illustration purposes. It does not allow users to copy data, or portions thereof, for use by third-party software. If you have questions about this agreement, please contact the Enterprise Systems Director at the University of Arkansas.
    </p>
    <div class="checkbox">
        <label><input type="checkbox" required>I Agree</label>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
    <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
{!! Form::close() !!}
@endsection

@push('scripts')
    <script>
        $( function() {
            $( ".datepicker" ).datepicker({
                dateFormat: "yy-mm-dd"
            });
        } );
    </script>
@endpush

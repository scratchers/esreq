@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <h1>Create Request</h1>

    <div class="well">
    {!! Form::open(['class'=>'form-horizontal']) !!}
        <div class="well">
            <h3>Platforms</h3>
            <div class="form-group"> 
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                        <label>{!! Form::checkbox('IBM') !!}IBM</label>
                    </div>
                </div>
            </div>

            <div class="form-group"> 
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                        <label>{!! Form::checkbox('Microsoft') !!}Microsoft</label>
                    </div>
                </div>
            </div>

            <div class="form-group"> 
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                        <label>{!! Form::checkbox('SAP') !!}SAP</label>
                        <div class="alert alert-warning" role="alert">
                            Must be an <a href="https://go.sap.com/training-certification/university-alliances.html" target="_blank">SAP University Alliances</a> Member
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group"> 
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                        <label>{!! Form::checkbox('SAS') !!}SAS</label>
                    </div>
                </div>
            </div>

            <div class="form-group"> 
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                        <label>{!! Form::checkbox('Teradata') !!}Teradata</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="well">
            <h3>Number of Accounts</h3>
            <div class="form-group">
                {!! Form::label('faculty_accounts', 'Faculty:', ['class'=>'control-label col-sm-2']) !!}
                <div class="col-sm-10">
                    {!! Form::number('faculty_accounts', null, ['class'=>'form-control', 'min'=>0]) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('student_accounts', 'Student:', ['class'=>'control-label col-sm-2']) !!}
                <div class="col-sm-10">
                    {!! Form::number('student_accounts', null, ['class'=>'form-control', 'min'=>0]) !!}
                </div>
            </div>
        </div>

        <div class="well">
            <h3>Academic Course Information</h3>
            <div class="form-group">
                {!! Form::label('course_name', 'Course Name:', ['class'=>'control-label col-sm-2']) !!}
                <div class="col-sm-10">
                    {!! Form::text('course_name', null, ['class'=>'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('date_begin', 'Start Date:', ['class'=>'control-label col-sm-2']) !!}
                <div class="col-sm-10">
                    {!! Form::date('date_begin', null, ['class'=>'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('date_end', 'End Date:', ['class'=>'control-label col-sm-2']) !!}
                <div class="col-sm-10">
                    {!! Form::date('date_end', null, ['class'=>'form-control']) !!}
                </div>
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
    </div>
@endsection

<div class="panel panel-default">

    <div class="panel-heading">
        <h2 class="panel-title">Accounts/Passwords/Notes to Requestor</h2>
    </div>

    <div class="panel-body">
    {!! Form::open(['class'=>'form-horizontal']) !!}
        {!! Form::textarea('note', $esrequest->note, ['class'=>'form-control']) !!}
    </div>

    <div class="panel-footer">
        <button type="submit" class="btn btn-primary">Save &amp; Fulfill Request</button>
    {!! Form::close() !!}
    </div>

</div>

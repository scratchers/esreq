<div class="panel panel-default">
    <div class="panel-body">
        <a
            href="{{ route('admin.facultyAccount.assign', $esrequest->user) }}"
            onclick="return showAjaxModal(this)"
            class="btn btn-primary"
        >
            Assign New Faculty Account
        </a>
    </div>
</div>

<div class="well">
    {!! Form::open(['class'=>'form-horizontal']) !!}

        <h3>Accounts/Passwords/Notes to Requestor</h3>

        <div class="form-group">
            {!! Form::textarea('note', $esrequest->note, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save &amp; Fulfill Request</button>
        </div>

    {!! Form::close() !!}
</div>

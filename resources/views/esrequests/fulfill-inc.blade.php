<div class="well">
    {!! Form::open(['class'=>'form-horizontal']) !!}

        <h3>Accounts/Passwords/Notes to Requestor</h3>

        <div class="form-group">
            {!! Form::textarea('note', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Fulfill</button>
        </div>

    {!! Form::close() !!}
</div>

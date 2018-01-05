<p class="lead">
    {{ $esrequest->user->first_name }} {{ $esrequest->user->last_name }}, {{ $esrequest->user->institution->name }}
    <br/>
    <a href="mailto:{{ $esrequest->user->email }}">{{ $esrequest->user->email }}</a>
</p>

<div class="well">
@foreach($esrequest->getFields() as $key => $value)
    <div class="row row-striped">
        <div class="col-xs-12 col-md-2 text-md-right"><strong>{{ $key }}</strong></div>
        <div class="col-xs-12 col-md-10">{{ $value }}</div>
    </div>
@endforeach
</div>

@unless ( empty($esrequest->user_comment) )
<div class="panel panel-default">

    <div class="panel-heading">
        <h3 class="panel-title">User Comment</h3>
    </div>

    <div class="panel-body">
        {!! nl2br(e($esrequest->user_comment)) !!}
    </div>

</div>
@endunless

<div id="esrequests-partials-facacc">
@include('esrequests.partials.facacc')
</div>

@if (Auth::user()->can('administer', Esrequest::class) && Route::is('admin.requests.show'))
    @include('esrequests.partials.fulfill')
@else
    @unless ( empty($esrequest->note) )
    <div class="panel panel-default">

        <div class="panel-heading">
            <h3 class="panel-title">Admin Response</h3>
        </div>

        <div class="panel-body">
            <pre>{{ $esrequest->note }}</pre>
        </div>

    </div>
    @endunless
@endcan

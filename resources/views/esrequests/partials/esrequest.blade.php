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
<h2>User Comment</h2>
<div class="well">
    <p>{{ $esrequest->user_comment }}</p>
</div>
@endunless

<div class="panel panel-default">

  <div class="panel-heading">
    <h3 class="panel-title">Existing Faculty Accounts</h3>
  </div>

  <div class="panel-body">
  <ul>
    @foreach ( $esrequest->user->facultyAccounts as $facultyAccount )
        <li>
            <a
                href="{{ route('customer.facultyAccount.show', $facultyAccount) }}"
                onclick="return showAjaxModal(this)"
            >
                <label class="label label-info" style="font-size:120%">{{ $facultyAccount->username }}</label>
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

  @can('administer', FacultyAccount::class)
  <div class="panel-footer clearfix">
  <div class="pull-right">
      <a
          href="{{ route('admin.facultyAccount.assign', $esrequest->user) }}"
          onclick="return showAjaxModal(this)"
          class="btn btn-primary"
      >
          Assign New Faculty Account
      </a>
      {{ App\FacultyAccount::countNew() }} remaining
  </div>
  </div>
  @endcan

</div>

@if (Auth::user()->can('administer', Esrequest::class) && Route::is('admin.requests.show'))
    @include('esrequests.partials.fulfill')
@else
    @unless ( empty($esrequest->note) )
        <h2>Admin Response</h2>
        <div>
            <pre>{{ $esrequest->note }}</pre>
        </div>
    @endunless
@endcan

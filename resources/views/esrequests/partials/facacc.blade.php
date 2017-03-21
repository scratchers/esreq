<div class="panel panel-default">

  <div class="panel-heading">
    <h3 class="panel-title">Existing Faculty Accounts</h3>
  </div>

  <div class="panel-body">
  <p>Click on username for more details:</p>
  <ul>
    @foreach ( $esrequest->user->facultyAccounts as $facultyAccount )
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

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">{{ "{$facultyAccount->username} - {$facultyAccount->password}" }}</h4>
</div>

<div class="modal-body">
    <p>Associated Platforms</p>
    <ul>
        @foreach ( $facultyAccount->platforms as $platform )
        <li>
            <label class="label label-{{ $platform->name }}">
                {{ $platform->name }}
            </label>
            @can('administer', App\FacultyAccount::class)
                <a
                    href="{{ route('admin.facultyAccount.rmplatform', ['facultyAccount' => $facultyAccount, 'platform' => $platform]) }}"
                    onclick="return showAjaxModal(this)"
                    style="color:red"
                >
                    &nbsp;<i class="fa fa-trash" aria-hidden="true"></i>
                </a>
            @endcan
        </li>
        @endforeach
    </ul>
</div>

@can('administer', App\FacultyAccount::class)
<div class="well" style="margin:10px">
    <p>Associate Platforms with Faculty Account</p>
    <ul>
        @foreach ( App\Platform::all() as $platform )
        <li style="padding:5px">
            <a
                href="{{ route('admin.facultyAccount.addplatform', ['facultyAccount' => $facultyAccount, 'platform' => $platform]) }}"
                onclick="return showAjaxModal(this)"
                class="label label-{{ $platform->name }}"
            >
                Associate {{ $platform->name }}
            </a>
        </li>
        @endforeach
    </ul>
</div>
@endcan

<div class="modal-footer">
    {{ $facultyAccount->user->name or 'Unassigned' }}
</div>

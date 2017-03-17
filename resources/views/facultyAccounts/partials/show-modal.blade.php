<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">{{ "{$facultyAccount->username} - {$facultyAccount->password}" }}</h4>
</div>

<div class="modal-body">
    <ul>
        @foreach ( $facultyAccount->platforms as $platform )
        <li>
            <label class="label label-{{ $platform->name }}">
                {{ $platform->name }}
            </label>
        </li>
        @endforeach
    </ul>
</div>

<div class="modal-footer">
    {{ $facultyAccount->user->name or 'Unassigned' }}
</div>

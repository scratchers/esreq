@extends('layouts.app')

<?php $platforms = App\Platform::all(); ?>

@section('content')
<h1>Faculty Accounts</h1>

@if ( $facultyAccounts->isEmpty() )
    <p class="lead">You have no faculty accounts.</p>
@else
<table class="datatable">
    <thead>
        <tr>
            <th>User</th>
            <th>Username</th>
            @foreach ( $platforms as $platform )
                @unless ($platform->name === 'SAS')
                    <th>{{ $platform->name }}</th>
                @endunless
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ( $facultyAccounts as $facultyAccount )
        <tr>
            <td>{{ $facultyAccount->user->name }}</td>

            <td>
                <a
                    href="{{ route('customer.facultyAccount.show', $facultyAccount) }}"
                    onclick="return showAjaxModal(this)"
                >
                    {{ $facultyAccount->username }}
                </a>
            </td>

            @foreach ( $platforms as $platform )
                @unless ($platform->name === 'SAS')
                    <td>{{ $facultyAccount->platforms->contains($platform) ? $platform->name : '' }}</td>
                @endunless
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>
@endif

@endsection

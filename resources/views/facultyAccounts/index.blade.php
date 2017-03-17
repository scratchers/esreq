@extends('layouts.app')

@section('content')
<h1>Faculty Accounts</h1>

<ul>
    @forelse ( $facultyAccounts as $facultyAccount )
    <li>
        <a href="{{ route('customer.facultyAccount.show', $facultyAccount) }}">
            {{ $facultyAccount->username }}
        </a>

        @foreach ( $facultyAccount->platforms as $platform )
        <label class="label label-{{ $platform->name }}">
            {{ $platform->name }}
        </label>
        @endforeach
    </li>
    @empty
    <p class="lead">You have no faculty accounts.</p>
    @endforelse
</ul>

@endsection

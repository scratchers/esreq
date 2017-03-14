@extends('layouts.app')

@section('content')
<h1>Instructions</h1>

<h2>Remote Desktop Connection</h2>
<ul>
    @foreach ( App\Platform::all() as $platform )
        <li>
            <a href='{{ asset("downloads/remote-desktop-{$platform->name}.pdf") }}'>
                {{ $platform->name }}
            </a>
        </li>
    @endforeach
</ul>

@endsection

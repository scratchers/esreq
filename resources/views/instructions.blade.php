@extends('layouts.app')

@section('content')
<h1>Instructions</h1>

<h2>Remote Desktop Connection</h2>
<ul>
    @foreach ( App\Esrequest::platforms() as $platform )
        <li>
            <a href='{{ asset("downloads/remote-desktop-$platform.pdf") }}'>
                {{ $platform }}
            </a>
        </li>
    @endforeach
</ul>

@endsection

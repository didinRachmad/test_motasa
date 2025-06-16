@extends('layouts.app')

@section('content')
    @include('layouts.header')
    @include('layouts.sidebar')
    <main class="main-wrapper">
        <div class="main-content">
            @yield('dashboard-content')
        </div>
    </main>
    {{-- @include('components.switcher') --}}

    @vite(['resources/css/dashboard.css', 'resources/js/dashboard.js'])
@endsection

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script>
        window.App = {!! json_encode([
            'csrfToken' => csrf_token(),
            'signedIn' => Auth::check(),
            'user' => Auth::user()
        ]) !!};
    </script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Dosis:400,500,600,700" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('head')
</head>

<body class="font-sans bg-green-lighter h-full">
<div id="app" class="flex flex-col min-h-full">
    @include('layouts.nav')

    <div class="container mx-auto flex flex-1">
        <div class="flex flex-1">
            @section('sidebar')
                @include('sidebar')
            @show

            <div class="px-10 bg-white flex-1">
                @yield('content')
            </div>

            @Include('channels-sidebar')
        </div>
    </div>

    <flash message="{{ session('flash') }}"></flash>

    <div v-cloak>
        @include('modals.all')
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>
@yield('scripts')
</body>
</html>

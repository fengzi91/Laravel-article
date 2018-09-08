<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'LaraBBS') - 梗来了 - 梗的搬运工</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')
</head>

<body class="mdui-theme-primary-blue mdui-theme-accent-deep-orange">
    <div class="{{ route_class() }}-page mdui-clearfix" id="app">

        @include('layouts._header')

            @yield('content')

        @include('layouts._footer')
    </div>
    @if (app()->isLocal())
        @include('sudosu::user-selector')
    @endif
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
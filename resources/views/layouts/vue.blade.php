<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta content="width=device-width,initial-scale=1,minimal-ui" name="viewport">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic|Material+Icons">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LaraBBS') - 梗来了 - 梗的搬运工</title>
    <link href="{{ asset('css/material.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">
    <script>
    window.App = {!! json_encode([
        'csrfToken' => csrf_token(),
        'user' => Auth::user(),
        'signIn' => Auth::check(),
        'siteName' => setting('site_name', '梗来了'),
        'topicData' => $topic
    ]) !!};
    </script>
    @yield('scripts')
  </head>

  <body>
    <div id="app">
      @yield('content')
    </div>
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/vue.js') }}"></script>
    <script>
        const app = new Vue({
            el: '#app',
            methods: {
            }
        });
    </script>
  </body>
</html>
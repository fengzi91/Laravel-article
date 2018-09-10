<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta content="width=device-width,initial-scale=1,minimal-ui" name="viewport">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic|Material+Icons">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'LaraBBS') - 梗来了 - 梗的搬运工</title>
  </head>

  <body>
    <div id="app">
      @yield('content')
    </div>

    <script src="{{ asset('js/vue.js') }}"></script>
  </body>
</html>
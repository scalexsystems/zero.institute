<!DOCTYPE html>
<html lang="{!! config('app.locale') !!}" id="app">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">

    <title>@yield('title', 'Zero: Open Technology for Education')</title>

    @include('partials.meta')

    {{--Web App Icon & Theme--}}
    @include('partials.icon')

    {{--Analytics--}}
    @include('web.partials.analytics')

    {{--CSRF Token--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{--Scripts--}}
    <script>
    window.Laravel = <?php echo json_encode(
            [
                    'csrfToken' => csrf_token(),
            ]
    ); ?>
    </script>

    {{--Styles--}}
    <link href="{!! elixir('css/web.css') !!}" rel="stylesheet">
    <% for (var css in htmlWebpackPlugin.files.css) { %>
    <link href="<%= htmlWebpackPlugin.files.css[css] %>" rel="stylesheet">
    <% } %>
    @yield('in-head')
</head>
<body>
@yield('before-body')
@yield('content')
<% for (var chunk in htmlWebpackPlugin.files.chunks) { %>
<script src="<%= htmlWebpackPlugin.files.chunks[chunk].entry %>"></script>
<% } %>
@yield('after-body')
</body>
</html>
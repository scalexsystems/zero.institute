<!DOCTYPE html>
<html lang="{!! config('app.locale') !!}" id="app">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Zero: Open Technology for Education')</title>
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
          content="Still spending lacs on low-quality administration tools? Introducing Zero, Open Technology for Education. Zero is available free of cost. Get invited for early access!">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Scalex Systems">
    <meta name="viewport" content="width=device-width">

    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    {{--Open Graph--}}
    <meta property="og:title" content="Zero: Open Technology for Education">
    <meta property="og:site_name" content="Scalex Systems">
    <meta property="og:url" content="http://zero.institute/">
    <meta property="og:description"
          content="Still spending lacs on low-quality administration tools? Introducing Zero, Open Technology for Education. Zero is available free of cost. Get invited for early access!">
    <meta property="og:type" content="product">
    <meta property="og:image" content="http://zero.institute/img/banner.png">

    {{--Twitter Card--}}
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@scalexsystems">
    <meta name="twitter:title" content="Zero: Open Technology for Education">
    <meta name="twitter:description"
          content="Still spending lacs on low-quality administration tools? Introducing Zero, Open Technology for Education. Zero is available free of cost. Get invited for early access!">
    <meta name="twitter:image" content="http://zero.institute/img/banner.png">
    <meta name="twitter:label1" content="for less than 2000 students/year">
    <meta name="twitter:data1" content="Price ₹0">

    {{--Web App Icon & Theme--}}
    @include('web.partials.icon')

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
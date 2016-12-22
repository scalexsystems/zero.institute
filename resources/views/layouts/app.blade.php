<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @include('partials.meta')

    {{--Web App Icon & Theme--}}
    @include('partials.icon')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{--Title--}}
    <title>{{ config('app.name', 'Zero') }}</title>

    @yield('styles')
    @yield('snippets')
</head>
<body>
    @yield('content')
    @yield('scripts')
</body>
</html>

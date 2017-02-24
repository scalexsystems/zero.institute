@extends('layouts.app')

@section('content')
    <div id="app"></div>
@endsection

@section('styles')
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script src="{{ mix('/manifest.js') }}" defer></script>
    <script src="{{ mix('/vendor/vue.js') }}" defer></script>
    <script src="{{ mix('/vendor/plugins.js') }}" defer></script>
    <script src="{{ mix('/vendor/others.js') }}" defer></script>
    <script src="{{ mix('/vendor/bootstrap.js') }}" defer></script>
    <script src="{{ mix('/vendor/components.js') }}" defer></script>
    <script src="{{ mix('/vendor/echo.js') }}" defer></script>
    <script src="{{ mix('/main.js') }}" defer></script>
@endsection

@section('snippets')
    <script>
    window.Laravel = <?php echo json_encode(
        [
            'csrfToken' => csrf_token(),
            'message' => session('message'),
            'user' => (new \Scalex\Zero\Services\UserService)->currentTransformed(),

            'broadcast' => config('broadcasting.front.'.config('broadcasting.default')),
        ]); ?>
    </script>
@endsection

@extends('layouts.app')

@include('app.vue')

@section('content')
    <div id="app"></div>
@endsection

@section('styles')
    @yield('vue-styles')
@endsection

@section('scripts')
    @yield('vue-scripts')
@endsection

@section('snippets')
    <script>
    window.Laravel = <?php echo json_encode(
            [
                    'csrfToken' => csrf_token(),
                    'message' => session('message'),
                    'user' => transform(current_user()),

                    'broadcast' => [
//                            'broadcaster' => 'pusher',
//                            'key' => '4227a2c3d458f6e17162',
//                            'cluster' => 'ap1',
//                            'encrypted' => true,
                            'broadcaster' => 'socket.io',
                            'host' => 'http://io.zero.institute.app:6001/',
                            'namespace' => 'Scalex.Zero.Events',
                    ],
            ]); ?>
    </script>
@endsection
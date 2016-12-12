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

                    'broadcast' => config('broadcasting.front.'.config('broadcasting.default')),
            ]); ?>
    </script>
@endsection

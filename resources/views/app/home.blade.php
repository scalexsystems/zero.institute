@extends('layouts.app')

@section('content')
    <div id="app"></div>
@endsection

@section('styles')
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script src="{{ mix('manifest.js') }}"></script>
    <script src="{{ mix('vendor.js') }}"></script>
    <script src="{{ mix('/js/app.js') }}"></script>
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

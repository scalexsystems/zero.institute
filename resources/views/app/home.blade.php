@extends('layouts.app')

@section('contents')
    <h1>Hello World!</h1>
@endsection

@section('styles')
@endsection

@section('scripts')
@endsection

@section('snippets')
    <script>
    window.Laravel = <?php echo json_encode([
                                                    'csrfToken' => csrf_token(),
                                                    'message' => session('message'),
                                                    'user' => transform(current_user())
                                            ]); ?>
    </script>
@endsection
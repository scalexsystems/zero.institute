@extends('layouts.web')

@section('content')
    <div style="background: white" class="container v-full d-flex flex-row justify-content-center align-items-center">
        <div class="container py-3">
            <img class="mb-3" src="{{ asset('img/zero-h-logo.png')}}">

            <p class="mb-2" style="font-size: 1.5rem">Hey,</p>
            <p class="mb-2" style="font-size: 1.5rem">Please check your institute email for further instructions!</p>
            <p class="mb-2" style="font-size: 1.5rem">Registration instructions are sent from: register@zero.institute</p>
            <p class="mb-2" style="font-size: 1.5rem">In case you did not receive any email, contact your institute system administrator.</p>
            <p class="mb-2" style="font-size: 1.5rem">--<br>Zero</p>
        </div>

        <div class="container text-center mt-3 mb-1">
            <a href="/" class="text-muted">Go Back</a>
        </div>
    </div>
@endsection

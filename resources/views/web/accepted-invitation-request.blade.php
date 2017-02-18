@extends('layouts.web')

@section('title')
    Invitation Request | Zero: Open Technology for Education
@endsection

@section('content')
    @include('web.partials.header')
    <section id="intro">
        <div class="container">
            <div class="row invite-form">
                <div class="col-12 text-center">
                    <i class="fa fa-3x fa-check-square-o"></i>
                    <h1 class="p-y-1">Congratulations!</h1>
                    <p>Added to Invite list! Please check your inbox for invite verification.</p>
                </div>

                <div class="col-12 text-center p-t-3">
                    <p class="text-muted">Spread the word for Open Technology</p>
                </div>

                <div class="col-12 col-md-10 offset-md-1 social-invites">
                    @include('web.partials.share')
                </div>
            </div>
        </div>
    </section>
    @include('web.partials.footer')
@endsection

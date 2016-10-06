@extends('layouts.web')


@section('title')
  Spread the Word | Zero: Open Technology for Education
@endsection

@section('content')
  @include('web.partials.header')
  <section id="intro">
    <div class="container">
      <div class="row invite-form">
        <div class="col-xs-12 text-xs-center">
          <h1 class="p-y-1">Spread the Word for Open Technology</h1>
          <p>We are building Zero with an aim to make technology accessible to every educational institute.</p>
        </div>

        <div class="col-xs-12 col-md-10 offset-md-1 social-invites m-b-3">
          @include('web.partials.share')
        </div>
      </div>
    </div>
  </section>
  @include('web.partials.footer')
@endsection

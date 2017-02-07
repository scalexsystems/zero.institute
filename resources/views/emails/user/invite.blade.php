@extends('layouts.mail')

@section('body')
    <p>Hello!<br>
        <br>
        You are invited to access Scalex Zero as a {{ $type }} of {{ $school }} by institute administrator - {{ $name }}.</p>

    <p>
      <a href="{{ $url }}"
         style="color: #fff; text-decoration: none; background-color: #007ee7; display: inline-block; font-weight: normal; line-height: 1.25; text-align: center; white-space: nowrap; vertical-align: middle; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; border: 1px solid #007ee7; padding: 0.5rem 1rem; border-radius: 0.25rem; -webkit-transition: all 0.2s ease-in-out; transition: all 0.2s ease-in-out;">
        Access my account
      </a>
    </p>

    <p> <a href="https://www.youtube.com/watch?v=Q0FRHSRaLE8"> Watch this video to learn more about Zero </a> </p>

    <p>
        <img src="{{ asset('/img/web/zero.png') }}">
    </p>

    <p>If you have any problem logging in, contact us here: support@zero.institute</p>
@endsection

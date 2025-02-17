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

    <p>Click on the video to learn more about Zero.</p>

    <p>
        <iframe width="853" height="480" src="https://www.youtube.com/embed/Q0FRHSRaLE8?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
    </p>

    <p>If you have any problem logging in, contact us here: support@zero.institute</p>
@endsection

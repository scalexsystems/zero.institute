@extends('layouts.mail')

@section('body')
    <p style="margin-bottom: 16px">
        Hello {{ $name ?? '' }}<br>
        <br>
        To make sure we've got the right person, please verify your email with this button:
    </p>
    <div style="margin: 32px auto; text-align: center;">
        <a href="{{ $url }}"
           style="color: #fff; text-decoration: none; background-color: #007ee7; display: inline-block; font-weight: normal; line-height: 1.25; text-align: center; white-space: nowrap; vertical-align: middle; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; border: 1px solid #007ee7; padding: 1rem 2.5rem; border-radius: 0.25rem; -webkit-transition: all 0.2s ease-in-out; transition: all 0.2s ease-in-out;">
            Verify Your Email
        </a>
    </div>

    <p style="margin-bottom: 16px; font-size: 14px; color: #b3b3b3">
        or copy and paste the link below in your browser: <br>
        <a href="{{ $url }}" style="color: #b3b3b3">{{ $url }}</a>
    </p>
@endsection

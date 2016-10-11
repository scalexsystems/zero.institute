<body bgcolor="#e7e7e7" style="background: #e7e7e7; padding: 16px; font-size: 16px; line-height: 1.5; font-weight: normal; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif">

<div style="margin: 16px auto 32px; text-align: center">
    <a href="{{ url('/') }}"><img src="{{ $message->embed(public_path('img/zero-h-logo.png')) }}" alt="Zero" height="23" width="101"></a>
</div>

@yield('header')

<div style="margin: 0 auto; padding: 16px; max-width: 600px; background: white; border-radius: 4px; box-shadow: #2d2d2d">
    @yield('body')
</div>

@yield('footer')

<div style="margin: 32px 16px 16px">
    <p style="text-align: center; color: #b3b3b3; font-size: 11px; margin-bottom: 16px">
        Copyright &copy; {{ \Carbon\Carbon::now()->format('Y') }} Scalex Systems Private Limited
    </p>

    <p style="text-align: center; color: #b3b3b3; font-size: 9px; margin-bottom: 16px">
        Scalex Systems Private Limited, 203, A/1, Shree Laxmi Park-I, Behind Kores Towers, Vartak Nagar, Thane - 400606, Maharashtra, IN<br>
        CIN: U74900MH2016PTC273793 Phone: 91 83 7399 4808 <br>
        Email: <a href="mailto:hello@scalex.xyz" style="color: #b3b3b3!important;">hello@scalex.xyz</a> Website: <a
                href="http://scalex.xyz" style="color: #b3b3b3">http://scalex.xyz</a>
    </p>
</div>
</body>
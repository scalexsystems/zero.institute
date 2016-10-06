<body bgcolor="#e7e7e7" style="background: #e7e7e7; padding: 24px 0; font-size: 18px">
  <div style="margin: auto auto; background: white; padding: 48px; border-radius: 4px; max-width: 650px; color: #2d2d2d; font-weight: lighter">
    <img src="{{ $message->embed(public_path('img/zero-h-logo.png')) }}" alt="Zero" height="23" width="101">
    <p>
      <br>
    </p>

    <p>Hello, <br>
      <br>
      To make sure we've got the right person, please verify your email with this button:</p>

    <p>
      <a href="{{ $url }}"
         style="color: #fff; text-decoration: none; background-color: #007ee7; display: inline-block; font-weight: normal; line-height: 1.25; text-align: center; white-space: nowrap; vertical-align: middle; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; border: 1px solid #007ee7; padding: 0.5rem 1rem; border-radius: 0.25rem; -webkit-transition: all 0.2s ease-in-out; transition: all 0.2s ease-in-out;">
        Verify
      </a>
    </p>

    <p>
      <br>
      Thanks for joining Zero!<br>
      <br>
      -- <br>
      Zero Team</p>
  </div>

  <p style="text-align: center; color: #b3b3b3; font-size: 11px">
    <br>
    Copyright &copy; {{ \Carbon\Carbon::now()->format('Y') }} Scalex Systems
  </p>
</body>
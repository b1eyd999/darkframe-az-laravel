@include('partials.head')
<body>
@include('partials.header')
@include('partials.flash')

<div class="auth-wrap">
  <div class="auth-card">
    <h1>E-poçtu təsdiqlə</h1>
    <p class="lead">{{ Auth::user()->email }} ünvanına göndərilən 6 rəqəmli kodu daxil edin.</p>

    <form action="/verify-email" method="POST">
      @csrf
      <div class="field">
        <label for="code">Təsdiq kodu</label>
        <input type="text" id="code" name="code" required maxlength="6" inputmode="numeric" pattern="[0-9]{6}" placeholder="000000" autofocus>
      </div>
      <button type="submit" class="btn btn-primary btn-block">Təsdiqlə</button>
    </form>

    <form action="/verify-email/resend" method="POST" class="auth-switch">
      @csrf
      <button type="submit" style="background:none; border:none; padding:0; font:inherit; cursor:pointer; color:var(--accent-lime); font-weight:700;">Kodu yenidən göndər</button>
    </form>
  </div>
</div>

@include('partials.footer')
</body>
</html>

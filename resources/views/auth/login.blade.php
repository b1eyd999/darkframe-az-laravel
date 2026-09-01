@include('partials.head')
<body>
@include('partials.header')
@include('partials.flash')

<div class="auth-wrap">
  <div class="auth-card">
    <h1>Daxil ol</h1>
    <p class="lead">Hesabınıza daxil olub kurslara və pluginlərə giriş əldə edin.</p>

    <form action="/login" method="POST">
      @csrf
      <div class="field">
        <label for="email">E-poçt</label>
        <input type="email" id="email" name="email" required placeholder="siz@nümunə.com">
      </div>
      <div class="field">
        <label for="password">Şifrə</label>
        <input type="password" id="password" name="password" required placeholder="••••••••">
      </div>
      <button type="submit" class="btn btn-primary btn-block">Daxil ol</button>
    </form>

    <p class="auth-switch">Hesabınız yoxdur? <a href="/register">Qeydiyyatdan keçin</a></p>

    <div class="demo-creds">
      <strong>Demo hesablar:</strong><br>
      Admin: <code>admin@platform.local</code> / <code>admin123</code><br>
      İstifadəçi: <code>user@platform.local</code> / <code>user1234</code>
    </div>
  </div>
</div>

@include('partials.footer')
</body>
</html>

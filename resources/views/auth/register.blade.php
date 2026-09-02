@include('partials.head')
<body>
@include('partials.header')
@include('partials.flash')

<div class="auth-wrap">
  <div class="auth-card">
    <h1>Qeydiyyat</h1>
    <p class="lead">Yeni hesab yaradın və indi öyrənməyə başlayın.</p>

    <form action="/register" method="POST">
      @csrf
      <div class="field">
        <label for="full_name">Ad Soyad</label>
        <input type="text" id="full_name" name="full_name" required placeholder="Məs: Elvin Məmmədov">
      </div>
      <div class="field">
        <label for="phone">Əlaqə nömrəsi</label>
        <input type="tel" id="phone" name="phone" required placeholder="+994 XX XXX XX XX">
      </div>
      <div class="field">
        <label for="birth_date">Doğum tarixi</label>
        <input type="date" id="birth_date" name="birth_date" required>
      </div>
      <div class="field">
        <label for="username">İstifadəçi adı</label>
        <input type="text" id="username" name="username" required placeholder="istifadeci_adi">
      </div>
      <div class="field">
        <label for="email">E-poçt</label>
        <input type="email" id="email" name="email" required placeholder="siz@nümunə.com">
      </div>
      <div class="field">
        <label for="password">Şifrə</label>
        <input type="password" id="password" name="password" required placeholder="ən azı 6 simvol">
      </div>
      <div class="field">
        <label for="password2">Şifrənin təkrarı</label>
        <input type="password" id="password2" name="password2" required placeholder="••••••••">
      </div>
      <button type="submit" class="btn btn-primary btn-block">Qeydiyyatdan keç</button>
    </form>

    <p class="auth-switch">Artıq hesabınız var? <a href="/login">Daxil olun</a></p>
  </div>
</div>

@include('partials.footer')
</body>
</html>

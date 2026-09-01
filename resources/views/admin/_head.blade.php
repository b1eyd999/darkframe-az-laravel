@include('partials.head')
<body>
<div class="admin-layout">
  <aside class="admin-sidebar">
    <a href="/" class="logo"><img src="/images/logo.png" alt="DarkFrame.az" class="logo-img"></a>
    <nav class="admin-nav">
      <a href="/admin" class="{{ request()->is('admin') ? 'active' : '' }}">📊 İdarə paneli</a>
      <a href="/admin/courses" class="{{ request()->is('admin/courses*') ? 'active' : '' }}">🎬 Kurslar</a>
      <a href="/admin/plugins" class="{{ request()->is('admin/plugins*') ? 'active' : '' }}">🧩 Pluginlər</a>
      <a href="/admin/stats" class="{{ request()->is('admin/stats*') ? 'active' : '' }}">📈 Statistika</a>
      <a href="/admin/users" class="{{ request()->is('admin/users*') ? 'active' : '' }}">👤 İstifadəçilər</a>
      <a href="/" style="margin-top: 20px; border-top: 1px solid var(--card-border); padding-top: 20px;">← Sayta qayıt</a>
    </nav>
  </aside>
  <main class="admin-main">
    @include('partials.flash')

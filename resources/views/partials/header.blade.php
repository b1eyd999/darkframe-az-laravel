<header class="site-header">
  <div class="container nav">
    <a href="/" class="logo"><img src="/images/logo.png" alt="DarkFrame.az" class="logo-img"></a>
    <ul class="nav-links">
      <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Ana səhifə</a></li>
      <li><a href="/courses" class="{{ request()->is('courses*') ? 'active' : '' }}">Video Kurslar</a></li>
      <li><a href="/plugins" class="{{ request()->is('plugins*') ? 'active' : '' }}">Pluginlər</a></li>
      @auth
        @if (auth()->user()->isAdmin())
          <li><a href="/admin">Admin Panel</a></li>
        @endif
      @endauth
    </ul>
    <div class="nav-actions">
      @auth
        <span style="color: var(--text-dim); font-size: 0.9rem;">Salam, <strong style="color: var(--text);">{{ auth()->user()->username }}</strong></span>
        <form action="/logout" method="POST" style="margin:0;">
          @csrf
          <button type="submit" class="btn btn-outline btn-sm">Çıxış</button>
        </form>
      @else
        <a href="/login" class="btn btn-outline btn-sm">Daxil ol</a>
        <a href="/register" class="btn btn-primary btn-sm">Qeydiyyat</a>
      @endauth
    </div>
  </div>
</header>

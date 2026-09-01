@include('partials.head')
<body>
@include('partials.header')
@include('partials.flash')

<section class="hero">
  <div id="vanta-hero-bg" class="vanta-hero-bg"></div>
  <div class="hero-fade-bottom"></div>
  <div class="container">
    <span class="eyebrow">Video Kurslar &amp; Pluginlər</span>
    <h1 class="display">Bacarıqlarını <span class="grad">növbəti səviyyəyə</span><br>qaldır</h1>
    <p class="lead">
      Peşəkar video dərslər izlə, mütəxəssislərdən öyrən və işini sürətləndirəcək
      hazır pluginləri yüklə — hamısı bir platformada.
    </p>
    <div class="hero-actions">
      <a href="/courses" class="btn btn-primary">Kurslara bax</a>
      <a href="/plugins" class="btn btn-outline">Pluginləri kəşf et</a>
    </div>
  </div>
</section>

<!-- Hero arxa fonu: Vanta.js CELLS effekti (tam offline, lokal fayllardan) -->
<script src="/vendor/three.r134.min.js"></script>
<script src="/vendor/vanta.cells.min.js"></script>
<script>
  (function () {
    if (window.VANTA && window.VANTA.CELLS) {
      VANTA.CELLS({
        el: '#vanta-hero-bg',
        mouseControls: true,
        touchControls: true,
        gyroControls: false,
        minHeight: 200.0,
        minWidth: 200.0,
        scale: 1.0,
        color1: 0x0a1a06,
        color2: 0xc6ff1a,
        size: 1.4,
        speed: 0.9,
      });
    }
  })();
</script>

<section class="section">
  <div class="container">
    <div class="section-head">
      <h2>Video Kurslar</h2>
      <p>Başlanğıcdan irəli səviyyəyə qədər addım-addım təlimlər.</p>
    </div>
    @if ($courses->isEmpty())
      <div class="empty-state">Hələ heç bir kurs əlavə edilməyib.</div>
    @else
      <div class="grid">
        @foreach ($courses->take(3) as $course)
          <a class="card" href="/courses/{{ $course->id }}">
            <div class="stack-thumb">
              <span class="stack-layer l1" style="background-image:url('{{ $course->thumbnail }}')"></span>
              <span class="stack-layer l2" style="background-image:url('{{ $course->thumbnail }}')"></span>
              <img class="stack-main" src="{{ $course->thumbnail }}" alt="{{ $course->title }}">
            </div>
            <div class="card-body">
              <span class="card-tag">{{ $course->category }}</span>
              <h3>{{ $course->title }}</h3>
              <p class="desc">{{ $course->description }}</p>
              <div class="card-footer">
                <span>{{ $course->level }}</span>
                <span>Kursa bax →</span>
              </div>
            </div>
          </a>
        @endforeach
      </div>
      <div style="text-align:center; margin-top: 32px;">
        <a href="/courses" class="btn btn-outline">Bütün kursları gör</a>
      </div>
    @endif
  </div>
</section>

<section class="section glow-frame">
  <div class="container">
    <div class="section-head">
      <h2>Populyar Pluginlər</h2>
      <p>İş axınını sürətləndirəcək hazır alətlər.</p>
    </div>
    @if ($plugins->isEmpty())
      <div class="empty-state">Hələ heç bir plugin əlavə edilməyib.</div>
    @else
      <div class="grid">
        @foreach ($plugins as $plugin)
          <div class="card">
            <div class="stack-thumb stack-thumb--icon">
              <span class="stack-layer l1" style="background-image:url('{{ $plugin->icon }}')"></span>
              <span class="stack-layer l2" style="background-image:url('{{ $plugin->icon }}')"></span>
              <img class="stack-main" src="{{ $plugin->icon }}" alt="{{ $plugin->name }}">
            </div>
            <div class="card-body">
              <h3>{{ $plugin->name }}</h3>
              <p class="desc">{{ $plugin->description }}</p>
              <div class="card-footer">
                <span>{{ $plugin->compatible_program }}</span>
                <span>v{{ $plugin->version }}</span>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      <div style="text-align:center; margin-top: 32px;">
        <a href="/plugins" class="btn btn-outline">Bütün pluginləri gör</a>
      </div>
    @endif
  </div>
</section>

@include('partials.footer')
</body>
</html>

@include('partials.head')
<body>
@include('partials.header')
@include('partials.flash')

<section class="section">
  <div class="container">
    <div class="section-head">
      <h2>Pluginlər</h2>
      <p>İş axınınızı sürətləndirəcək hazır proqram əlavələri.</p>
    </div>

    <div class="browse-layout">
      @include('partials.program-filter', [
        'baseUrl' => '/plugins',
        'programs' => $programs,
        'programCounts' => $programCounts,
        'selectedProgram' => $selectedProgram,
        'panelTitle' => 'Proqramlar üzrə',
      ])

      <div>
        @if ($selectedProgram)
          <div class="active-filter-bar">
            <span>Filtr: <strong>{{ $selectedProgram }}</strong></span>
            <a href="/plugins" class="btn btn-outline btn-sm">Filtri təmizlə</a>
          </div>
        @endif

        @if ($plugins->isEmpty())
          <div class="empty-state">
            @if ($selectedProgram)
              "{{ $selectedProgram }}" üçün hələ plugin əlavə edilməyib.
            @else
              Hələ heç bir plugin əlavə edilməyib.
            @endif
          </div>
        @else
          <div class="grid">
            @foreach ($plugins as $plugin)
              <div class="card">
                <a href="/plugins/{{ $plugin->id }}" class="stack-thumb stack-thumb--icon">
                  <span class="stack-layer l1" style="background-image:url('{{ $plugin->icon }}')"></span>
                  <span class="stack-layer l2" style="background-image:url('{{ $plugin->icon }}')"></span>
                  <img class="stack-main" src="{{ $plugin->icon }}" alt="{{ $plugin->name }}">
                </a>
                <div class="card-body">
                  <span class="card-tag">{{ $plugin->compatible_program }}</span>
                  <h3><a href="/plugins/{{ $plugin->id }}">{{ $plugin->name }}</a></h3>
                  @include('partials.star-rating', ['rating' => (float) $plugin->reviews_avg_rating, 'count' => $plugin->reviews_count])
                  <p class="desc">{{ $plugin->description }}</p>
                  <div class="card-footer">
                    <span>v{{ $plugin->version }} · {{ $plugin->downloads }} yükləmə</span>
                  </div>
                  <div style="display:flex; gap:8px;">
                    <a href="/plugins/{{ $plugin->id }}" class="btn btn-outline btn-sm btn-block">Ətraflı</a>
                    @auth
                      <a href="/plugins/{{ $plugin->id }}/download" class="btn btn-primary btn-sm btn-block">Yüklə</a>
                    @else
                      <a href="/login" class="btn btn-outline btn-sm btn-block">Daxil ol</a>
                    @endauth
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </div>
  </div>
</section>

@include('partials.footer')
</body>
</html>

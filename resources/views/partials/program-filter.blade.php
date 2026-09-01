<aside class="program-panel">
  <h3 class="program-panel-title">{{ $panelTitle ?? 'Proqramlar üzrə' }}</h3>
  <div class="program-list">
    <a href="{{ $baseUrl }}" class="program-item {{ !$selectedProgram ? 'active' : '' }}">
      <span class="program-badge program-badge-all">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="3" width="7" height="7" rx="1.5"></rect>
          <rect x="14" y="3" width="7" height="7" rx="1.5"></rect>
          <rect x="3" y="14" width="7" height="7" rx="1.5"></rect>
          <rect x="14" y="14" width="7" height="7" rx="1.5"></rect>
        </svg>
      </span>
      <span class="program-name">Hamısı</span>
    </a>
    @foreach ($programs as $p)
      <a
        href="{{ $baseUrl }}?program={{ urlencode($p['name']) }}"
        class="program-item {{ $selectedProgram === $p['name'] ? 'active' : '' }}"
        style="--p-color:{{ $p['color'] }};"
      >
        <span class="program-badge">{{ $p['tag'] }}</span>
        <span class="program-name">{{ $p['name'] }}</span>
        @if (!empty($programCounts[$p['name']]))
          <span class="program-count">{{ $programCounts[$p['name']] }}</span>
        @endif
      </a>
    @endforeach
  </div>
</aside>

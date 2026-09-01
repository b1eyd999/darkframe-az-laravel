@include('partials.head')
<body>
@include('partials.header')
@include('partials.flash')

<section class="section">
  <div class="container">
    <div class="section-head">
      <h2>Video Kurslar</h2>
      <p>Sizə uyğun kursu seçin və öyrənməyə bu gün başlayın.</p>
    </div>

    <div class="browse-layout">
      @include('partials.program-filter', [
        'baseUrl' => '/courses',
        'programs' => $programs,
        'programCounts' => $programCounts,
        'selectedProgram' => $selectedProgram,
        'panelTitle' => 'Proqramlar üzrə',
      ])

      <div>
        @if ($selectedProgram)
          <div class="active-filter-bar">
            <span>Filtr: <strong>{{ $selectedProgram }}</strong></span>
            <a href="/courses" class="btn btn-outline btn-sm">Filtri təmizlə</a>
          </div>
        @endif

        @if ($courses->isEmpty())
          <div class="empty-state">
            @if ($selectedProgram)
              "{{ $selectedProgram }}" üçün hələ kurs əlavə edilməyib.
            @else
              Hələ heç bir kurs əlavə edilməyib.
            @endif
          </div>
        @else
          <div class="grid">
            @foreach ($courses as $course)
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
        @endif
      </div>
    </div>
  </div>
</section>

@include('partials.footer')
</body>
</html>

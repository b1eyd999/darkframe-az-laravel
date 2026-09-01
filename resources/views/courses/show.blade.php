@include('partials.head')
<body>
@include('partials.header')
@include('partials.flash')

<div class="container detail-page">
  <div class="media-hero">
    @if ($lessons->count() > 0)
      <video id="mainPlayer" class="media-hero-video" controls poster="{{ $course->thumbnail }}" src="{{ $lessons[0]->video_url }}"></video>
    @else
      <div class="media-hero-video media-hero-video--fallback" style="background-image:url('{{ $course->thumbnail }}');">
        <span class="media-hero-fallback-label">Bu kursa hələ dərs əlavə edilməyib</span>
      </div>
    @endif
  </div>

  <div class="detail-grid">
    <div class="poster-frame">
      <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}">
    </div>

    <div class="overview-panel">
      <div class="course-meta">
        <span class="pill">{{ $course->category }}</span>
        <span class="pill">{{ $course->level }}</span>
        <span class="pill">{{ $lessons->count() }} dərs</span>
        <span class="pill">{{ $course->views }} baxış</span>
      </div>
      <h1 class="display" style="font-size: 2rem; text-align:left;">{{ $course->title }}</h1>
      @include('partials.star-rating', ['rating' => $avgRating, 'count' => $reviewCount])
      <p class="lead" style="text-align:left; margin: 16px 0;">{{ $course->description }}</p>
    </div>
  </div>

  @if ($lessons->count() > 0)
    <h2>Dərslər</h2>
    <div class="lesson-list">
      @foreach ($lessons as $i => $lesson)
        <div class="lesson-item {{ $i === 0 ? 'active' : '' }}" onclick="playLesson('{{ $lesson->video_url }}', this)" style="cursor:pointer;">
          <span class="lesson-num">{{ $i + 1 }}</span>
          <span class="lesson-title">{{ $lesson->title }}</span>
          <span class="lesson-duration">{{ $lesson->duration }}</span>
        </div>
      @endforeach
    </div>
  @endif

  @include('partials.review-section', [
    'reviewActionUrl' => "/courses/{$course->id}/review",
    'reviews' => $reviews,
    'myReview' => $myReview,
    'avgRating' => $avgRating,
    'reviewCount' => $reviewCount,
  ])
</div>

<script>
  function playLesson(url, el) {
    var player = document.getElementById('mainPlayer');
    if (!player) return;
    player.src = url;
    player.play();
    document.querySelectorAll('.lesson-item').forEach(function(item) {
      item.classList.remove('active');
    });
    el.classList.add('active');
    player.scrollIntoView({ behavior: 'smooth', block: 'center' });
  }
</script>

@include('partials.footer')
</body>
</html>

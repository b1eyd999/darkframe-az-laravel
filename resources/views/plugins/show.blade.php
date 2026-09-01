@include('partials.head')
<body>
@include('partials.header')
@include('partials.flash')

<div class="container detail-page">
  <div class="media-hero">
    @if ($plugin->preview_video)
      <video class="media-hero-video" controls poster="{{ $plugin->icon }}" src="{{ $plugin->preview_video }}"></video>
    @else
      <div class="media-hero-video media-hero-video--fallback" style="background-image:url('{{ $plugin->icon }}');">
        <span class="media-hero-fallback-label">Təqdimat videosu yoxdur</span>
      </div>
    @endif
  </div>

  <div class="detail-grid">
    @if ($plugin->icon === '/icons/plugin-default.png')
      <div class="poster-frame poster-frame--placeholder">
        <span>PLUGIN</span>
      </div>
    @else
      <div class="poster-frame">
        <img src="{{ $plugin->icon }}" alt="{{ $plugin->name }}">
      </div>
    @endif

    <div class="overview-panel">
      <div class="course-meta">
        <span class="pill">{{ $plugin->compatible_program }}</span>
        <span class="pill">v{{ $plugin->version }}</span>
        <span class="pill">{{ $plugin->downloads }} yükləmə</span>
      </div>
      <h1 class="display" style="font-size: 2rem; text-align:left;">{{ $plugin->name }}</h1>
      @include('partials.star-rating', ['rating' => $avgRating, 'count' => $reviewCount])
      <p class="lead" style="text-align:left; margin: 16px 0;">{{ $plugin->description }}</p>

      @auth
        <a href="/plugins/{{ $plugin->id }}/download" class="btn btn-primary">Pluginı yüklə</a>
      @else
        <a href="/login" class="btn btn-outline">Yükləmək üçün daxil olun</a>
      @endauth
    </div>
  </div>

  @include('partials.review-section', [
    'reviewActionUrl' => "/plugins/{$plugin->id}/review",
    'reviews' => $reviews,
    'myReview' => $myReview,
    'avgRating' => $avgRating,
    'reviewCount' => $reviewCount,
  ])
</div>

@include('partials.footer')
</body>
</html>

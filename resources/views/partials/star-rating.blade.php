@php
  $r = $rating ?? 0;
  $c = $count ?? 0;
  $showLabel = !($hideLabel ?? false);
  $rounded = (int) round($r);
@endphp
<div class="star-rating">
  <span class="star-rating-stars" aria-hidden="true">
    @for ($i = 1; $i <= 5; $i++)
      <span class="star {{ $i <= $rounded ? 'filled' : '' }}">★</span>
    @endfor
  </span>
  @if ($showLabel)
    @if ($c > 0)
      <span class="star-count">{{ number_format($r, 1) }} · {{ $c }} rəy</span>
    @else
      <span class="star-count star-count--empty">Hələ reytinq yoxdur</span>
    @endif
  @endif
</div>

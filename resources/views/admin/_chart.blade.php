@php
  // locals: $chartTitle, $chartData ([['label'=>..,'count'=>..]])
  $maxVal = max(1, ...array_column($chartData, 'count'));
@endphp
<div class="chart-block">
  <h3 class="chart-title">{{ $chartTitle }}</h3>
  <div class="chart">
    @foreach ($chartData as $d)
      <div class="chart-bar-wrap">
        <span class="chart-count">{{ $d['count'] }}</span>
        <div class="chart-bar" style="height: {{ max(4, round(($d['count'] / $maxVal) * 100)) }}%" title="{{ $d['label'] }}: {{ $d['count'] }}"></div>
        <span class="chart-label">{{ $d['label'] }}</span>
      </div>
    @endforeach
  </div>
</div>

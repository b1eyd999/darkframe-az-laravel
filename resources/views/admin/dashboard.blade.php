@include('admin._head')

<h1>İdarə paneli</h1>
<p class="lead" style="text-align:left; margin-bottom: 32px;">Platformanızın ümumi statistikası.</p>

<div class="stat-grid">
  <div class="stat-card stat-card--live">
    <div class="num"><span class="pulse-dot"></span><span id="live-online-num">{{ $onlineCount }}</span></div>
    <div class="label">Onlayn indi</div>
  </div>
  <div class="stat-card">
    <div class="num">{{ $stats['userCount'] }}</div>
    <div class="label">İstifadəçi</div>
  </div>
  <div class="stat-card">
    <div class="num">{{ $stats['courseCount'] }}</div>
    <div class="label">Kurs</div>
  </div>
  <div class="stat-card">
    <div class="num">{{ $stats['lessonCount'] }}</div>
    <div class="label">Dərs (video)</div>
  </div>
  <div class="stat-card">
    <div class="num">{{ $stats['pluginCount'] }}</div>
    <div class="label">Plugin</div>
  </div>
  <div class="stat-card">
    <div class="num">{{ $stats['totalDownloads'] }}</div>
    <div class="label">Plugin yükləməsi</div>
  </div>
</div>

<div class="admin-toolbar">
  <a href="/admin/courses/new" class="btn btn-primary">+ Yeni kurs</a>
  <a href="/admin/plugins/new" class="btn btn-outline">+ Yeni plugin</a>
  <a href="/admin/stats" class="btn btn-outline">📈 Ətraflı statistika</a>
</div>

<script>
  (function () {
    var el = document.getElementById('live-online-num');
    if (!el) return;
    setInterval(function () {
      fetch('/admin/stats/online.json')
        .then(function (r) { return r.json(); })
        .then(function (data) { el.textContent = data.count; })
        .catch(function () {});
    }, 5000);
  })();
</script>

@include('admin._footer')

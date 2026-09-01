@include('admin._head')

<h1>Statistika</h1>
<p class="lead" style="text-align:left; margin-bottom: 32px;">Saytın canlı və ümumi göstəriciləri.</p>

<div class="stat-grid">
  <div class="stat-card stat-card--live">
    <div class="num"><span class="pulse-dot"></span><span id="live-online-num">{{ $onlineCount }}</span></div>
    <div class="label">Onlayn indi</div>
  </div>
  <div class="stat-card">
    <div class="num">{{ $stats['userCount'] }}</div>
    <div class="label">Qeydiyyatlı istifadəçi</div>
  </div>
  <div class="stat-card">
    <div class="num">{{ $stats['newUsersWeek'] }}</div>
    <div class="label">Son 7 gündə yeni</div>
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
  <div class="stat-card">
    <div class="num">{{ $stats['adminCount'] }}</div>
    <div class="label">Admin</div>
  </div>
</div>

<div class="stats-card-head" style="margin-top: 36px;">
  <h2>Satış (plugin yükləmə) statistikası</h2>
</div>
<p class="field-hint" style="margin-top: -8px; margin-bottom: 18px;">
  Saytda hələ qiymət/ödəniş sistemi olmadığı üçün "satış" burada plugin yükləmələrinin sayı əsasında hesablanır.
</p>

<div class="stat-grid">
  <div class="stat-card">
    <div class="num">{{ $sales['today'] }}</div>
    <div class="label">Bu gün</div>
  </div>
  <div class="stat-card">
    <div class="num">{{ $sales['thisWeek'] }}</div>
    <div class="label">Bu həftə (son 7 gün)</div>
  </div>
  <div class="stat-card">
    <div class="num">{{ $sales['thisMonth'] }}</div>
    <div class="label">Bu ay</div>
  </div>
</div>

<div class="admin-form-card" style="max-width:none; margin-bottom: 24px;">
  <div class="charts-grid">
    @include('admin._chart', ['chartTitle' => 'Günlük (son 14 gün)', 'chartData' => $sales['daily']])
    @include('admin._chart', ['chartTitle' => 'Həftəlik (son 8 həftə)', 'chartData' => $sales['weekly']])
    @include('admin._chart', ['chartTitle' => 'Aylıq (son 6 ay)', 'chartData' => $sales['monthly']])
  </div>
</div>

<div class="stats-columns">
  <div class="admin-form-card" style="max-width:none;">
    <div class="stats-card-head">
      <h2>Hazırda onlayn olanlar</h2>
      <span class="pill" id="live-online-pill">{{ $onlineCount }} nəfər</span>
    </div>
    @if (empty($onlineList))
      <div class="empty-state" style="padding: 30px 10px;">Hazırda saytda heç kim yoxdur.</div>
    @else
      <div class="table-wrap">
        <table class="data-table" id="online-table">
          <thead>
            <tr>
              <th>İstifadəçi</th>
              <th>Rol</th>
              <th>Son siqnal</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($onlineList as $o)
              <tr>
                <td>{{ $o['username'] ?? 'Qonaq (giriş etməyib)' }}</td>
                <td>
                  @if ($o['role'] === 'admin')
                    <span class="badge badge-admin">Admin</span>
                  @elseif ($o['role'] === 'user')
                    <span class="badge badge-user">İstifadəçi</span>
                  @else
                    <span class="badge" style="background: rgba(255,255,255,0.08); color: var(--text-dim);">Qonaq</span>
                  @endif
                </td>
                <td>{{ $o['secondsAgo'] }} saniyə əvvəl</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
    <p class="field-hint" style="margin-top: 14px;">
      "Onlayn" — son 60 saniyə ərzində saytda aktiv olan (səhifə açan və ya açıq saxlayan) ziyarətçilərdir. Siyahı hər 5 saniyədən bir avtomatik yenilənir.
    </p>
  </div>

  <div class="admin-form-card" style="max-width:none;">
    <div class="stats-card-head">
      <h2>Ən çox yüklənən pluginlər</h2>
    </div>
    @if ($topPlugins->isEmpty())
      <div class="empty-state" style="padding: 30px 10px;">Hələ plugin əlavə edilməyib.</div>
    @else
      <div class="table-wrap">
        <table class="data-table">
          <thead>
            <tr><th>Plugin</th><th>Yükləmə sayı</th></tr>
          </thead>
          <tbody>
            @foreach ($topPlugins as $p)
              <tr><td>{{ $p->name }}</td><td>{{ $p->downloads }}</td></tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif

    <div class="stats-card-head" style="margin-top: 28px;">
      <h2>Ən çox baxılan kurslar</h2>
    </div>
    @if ($topCourses->isEmpty())
      <div class="empty-state" style="padding: 30px 10px;">Hələ kurs əlavə edilməyib.</div>
    @else
      <div class="table-wrap">
        <table class="data-table">
          <thead>
            <tr><th>Kurs</th><th>Baxış sayı</th></tr>
          </thead>
          <tbody>
            @foreach ($topCourses as $c)
              <tr><td>{{ $c->title }}</td><td>{{ $c->views }}</td></tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif

    <div class="stats-card-head" style="margin-top: 28px;">
      <h2>Son qeydiyyatlar</h2>
    </div>
    @if ($recentUsers->isEmpty())
      <div class="empty-state" style="padding: 30px 10px;">Hələ istifadəçi yoxdur.</div>
    @else
      <div class="table-wrap">
        <table class="data-table">
          <thead>
            <tr><th>İstifadəçi</th><th>Rol</th><th>Tarix</th></tr>
          </thead>
          <tbody>
            @foreach ($recentUsers as $u)
              <tr>
                <td>{{ $u->username }}</td>
                <td>
                  @if ($u->role === 'admin')
                    <span class="badge badge-admin">Admin</span>
                  @else
                    <span class="badge badge-user">İstifadəçi</span>
                  @endif
                </td>
                <td>{{ $u->created_at }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>
</div>

<script>
  (function () {
    var numEl = document.getElementById('live-online-num');
    var pillEl = document.getElementById('live-online-pill');
    var tableBody = document.querySelector('#online-table tbody');

    function roleBadge(role) {
      if (role === 'admin') return '<span class="badge badge-admin">Admin</span>';
      if (role === 'user') return '<span class="badge badge-user">İstifadəçi</span>';
      return '<span class="badge" style="background: rgba(255,255,255,0.08); color: var(--text-dim);">Qonaq</span>';
    }

    function refresh() {
      fetch('/admin/stats/online.json')
        .then(function (r) { return r.json(); })
        .then(function (data) {
          if (numEl) numEl.textContent = data.count;
          if (pillEl) pillEl.textContent = data.count + ' nəfər';
          if (tableBody) {
            tableBody.innerHTML = data.list.map(function (o) {
              return '<tr><td>' + (o.username || 'Qonaq (giriş etməyib)') + '</td><td>' +
                roleBadge(o.role) + '</td><td>' + o.secondsAgo + ' saniyə əvvəl</td></tr>';
            }).join('');
          }
        })
        .catch(function () {});
    }
    setInterval(refresh, 5000);
  })();
</script>

@include('admin._footer')

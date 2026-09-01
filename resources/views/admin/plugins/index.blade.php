@include('admin._head')

<div class="admin-toolbar">
  <h1 style="margin:0;">Pluginlərin idarəsi</h1>
  <a href="/admin/plugins/new" class="btn btn-primary">+ Yeni plugin</a>
</div>

@if ($plugins->isEmpty())
  <div class="empty-state">Hələ heç bir plugin əlavə edilməyib.</div>
@else
  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr>
          <th></th>
          <th>Ad</th>
          <th>Proqram</th>
          <th>Versiya</th>
          <th>Yükləmə sayı</th>
          <th>Əməliyyatlar</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($plugins as $plugin)
          <tr>
            <td><img class="plugin-icon" style="width:36px;height:36px;" src="{{ $plugin->icon }}" alt=""></td>
            <td><strong>{{ $plugin->name }}</strong></td>
            <td>{{ $plugin->compatible_program }}</td>
            <td>v{{ $plugin->version }}</td>
            <td>{{ $plugin->downloads }}</td>
            <td class="actions">
              <a href="/admin/plugins/{{ $plugin->id }}/edit" class="btn btn-outline btn-sm">Redaktə</a>
              <form action="/admin/plugins/{{ $plugin->id }}/delete" method="POST" onsubmit="return confirm('&quot;{{ $plugin->name }}&quot; pluginini silmək istədiyinizə əminsiniz?');" style="margin:0;">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">Sil</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endif

@include('admin._footer')

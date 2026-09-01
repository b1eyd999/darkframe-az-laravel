@include('admin._head')

<h1>{{ $plugin ? 'Plugini redaktə et' : 'Yeni plugin əlavə et' }}</h1>

<div class="admin-form-card">
  <form action="{{ $plugin ? '/admin/plugins/' . $plugin->id : '/admin/plugins' }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="field">
      <label for="name">Plugin adı</label>
      <input type="text" id="name" name="name" required value="{{ $plugin->name ?? '' }}" placeholder="Məs: Keying Pro">
    </div>
    <div class="field">
      <label for="description">Təsvir</label>
      <textarea id="description" name="description" placeholder="Plugin nə edir?">{{ $plugin->description ?? '' }}</textarea>
    </div>
    <div class="field">
      <label for="compatible_program">Uyğun proqram</label>
      <select id="compatible_program" name="compatible_program" required>
        <option value="">— Seçin —</option>
        @foreach ($programs as $p)
          <option value="{{ $p['name'] }}" {{ ($plugin->compatible_program ?? null) === $p['name'] ? 'selected' : '' }}>{{ $p['name'] }}</option>
        @endforeach
      </select>
      <p class="field-hint">Bu, "/plugins" səhifəsindəki "Proqramlar üzrə" bölməsi ilə eşləşir.</p>
    </div>
    <div class="field">
      <label for="version">Versiya</label>
      <input type="text" id="version" name="version" value="{{ $plugin->version ?? '1.0' }}" placeholder="1.0">
    </div>
    <div class="field">
      <label for="plugin_file">Plugin faylı (.zip){{ $plugin ? ' — boş buraxsanız mövcud fayl saxlanılır' : '' }}</label>
      <input type="file" id="plugin_file" name="plugin_file" {{ $plugin ? '' : 'required' }}>
      @if ($plugin)<p class="field-hint">Cari fayl: {{ $plugin->file_original_name }}</p>@endif
    </div>
    <div class="field">
      <label for="icon_file">İkon / poster şəkli (istəyə bağlı)</label>
      <input type="file" id="icon_file" name="icon_file" accept="image/*">
      @if ($plugin)<p class="field-hint">Boş buraxsanız cari ikon saxlanılır.</p>@endif
    </div>
    <div class="field">
      <label for="preview_video_file">Təqdimat videosu (istəyə bağlı)</label>
      <input type="file" id="preview_video_file" name="preview_video_file" accept="video/*">
      @if ($plugin && $plugin->preview_video)
        <p class="field-hint">Cari video mövcuddur — boş buraxsanız saxlanılır.</p>
      @else
        <p class="field-hint">Yüklənməsə, plugin səhifəsində video yerinə poster göstəriləcək.</p>
      @endif
    </div>
    <div style="display:flex; gap: 12px;">
      <button type="submit" class="btn btn-primary">{{ $plugin ? 'Yadda saxla' : 'Əlavə et' }}</button>
      <a href="/admin/plugins" class="btn btn-outline">Ləğv et</a>
    </div>
  </form>
</div>

@include('admin._footer')

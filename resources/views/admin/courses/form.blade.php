@include('admin._head')

<h1>{{ $course ? 'Kursu redaktə et' : 'Yeni kurs əlavə et' }}</h1>

<div class="admin-form-card">
  <form action="{{ $course ? '/admin/courses/' . $course->id : '/admin/courses' }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="field">
      <label for="title">Kurs adı</label>
      <input type="text" id="title" name="title" required value="{{ $course->title ?? '' }}" placeholder="Məs: VFX Artist 2.0">
    </div>
    <div class="field">
      <label for="description">Təsvir</label>
      <textarea id="description" name="description" placeholder="Kurs haqqında qısa məlumat">{{ $course->description ?? '' }}</textarea>
    </div>
    <div class="field">
      <label for="category">Kateqoriya</label>
      <input type="text" id="category" name="category" value="{{ $course->category ?? '' }}" placeholder="Məs: Vizual Effektlər">
    </div>
    <div class="field">
      <label for="program">Proqram (saytda "Proqramlar üzrə" bölməsi üçün)</label>
      <select id="program" name="program">
        <option value="">— Seçilməyib —</option>
        @foreach ($programs as $p)
          <option value="{{ $p['name'] }}" {{ ($course->program ?? null) === $p['name'] ? 'selected' : '' }}>{{ $p['name'] }}</option>
        @endforeach
      </select>
      <p class="field-hint">Bu kurs "/courses" səhifəsində hansı proqram bölməsində görünəcəyini müəyyən edir.</p>
    </div>
    <div class="field">
      <label for="level">Səviyyə</label>
      <input type="text" id="level" name="level" value="{{ $course->level ?? 'Başlanğıc' }}" placeholder="Məs: Başlanğıc">
    </div>
    <div class="field">
      <label for="thumbnail_file">Üz qabığı şəkli (istəyə bağlı)</label>
      <input type="file" id="thumbnail_file" name="thumbnail_file" accept="image/*">
      @if ($course)<p class="field-hint">Boş buraxsanız cari şəkil saxlanılır.</p>@endif
    </div>
    <div style="display:flex; gap: 12px;">
      <button type="submit" class="btn btn-primary">{{ $course ? 'Yadda saxla' : 'Əlavə et' }}</button>
      <a href="/admin/courses" class="btn btn-outline">Ləğv et</a>
    </div>
  </form>
</div>

@if ($course)
  <h2 style="margin-top: 48px;">Dərslər</h2>
  <div class="lesson-list" style="max-width: 680px;">
    @foreach (($lessons ?? []) as $i => $lesson)
      <div class="lesson-item">
        <span class="lesson-num">{{ $i + 1 }}</span>
        <span class="lesson-title">{{ $lesson->title }}</span>
        <span class="lesson-duration">{{ $lesson->duration }}</span>
        <form action="/admin/courses/{{ $course->id }}/lessons/{{ $lesson->id }}/delete" method="POST" onsubmit="return confirm('Bu dərsi silmək istədiyinizə əminsiniz?');" style="margin:0;">
          @csrf
          <button type="submit" class="btn btn-danger btn-sm">Sil</button>
        </form>
      </div>
    @endforeach
  </div>

  <div class="admin-form-card" style="margin-top: 20px;">
    <h3 style="margin-top:0;">Yeni dərs əlavə et</h3>
    <form action="/admin/courses/{{ $course->id }}/lessons" method="POST">
      @csrf
      <div class="field">
        <label for="lesson_title">Dərsin adı</label>
        <input type="text" id="lesson_title" name="title" required placeholder="Məs: Giriş">
      </div>
      <div class="field">
        <label for="video_url">Video URL / yol</label>
        <input type="text" id="video_url" name="video_url" placeholder="/videos/nümunə.mp4 və ya tam link">
        <p class="field-hint">Yerli video faylı üçün <code>public/videos/</code> qovluğuna faylı əlavə edib yolunu buraya yazın.</p>
      </div>
      <div class="field">
        <label for="duration">Müddət</label>
        <input type="text" id="duration" name="duration" placeholder="Məs: 12:30">
      </div>
      <button type="submit" class="btn btn-primary">Dərsi əlavə et</button>
    </form>
  </div>
@endif

@include('admin._footer')

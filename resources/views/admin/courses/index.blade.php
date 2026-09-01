@include('admin._head')

<div class="admin-toolbar">
  <h1 style="margin:0;">Kursların idarəsi</h1>
  <a href="/admin/courses/new" class="btn btn-primary">+ Yeni kurs</a>
</div>

@if ($courses->isEmpty())
  <div class="empty-state">Hələ heç bir kurs əlavə edilməyib.</div>
@else
  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr>
          <th></th>
          <th>Başlıq</th>
          <th>Kateqoriya</th>
          <th>Səviyyə</th>
          <th>Əməliyyatlar</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($courses as $course)
          <tr>
            <td><img src="{{ $course->thumbnail }}" alt="" style="width:64px;height:36px;object-fit:cover;border-radius:6px;"></td>
            <td><strong>{{ $course->title }}</strong></td>
            <td>{{ $course->category }}</td>
            <td>{{ $course->level }}</td>
            <td class="actions">
              <a href="/admin/courses/{{ $course->id }}/edit" class="btn btn-outline btn-sm">Redaktə</a>
              <form action="/admin/courses/{{ $course->id }}/delete" method="POST" onsubmit="return confirm('&quot;{{ $course->title }}&quot; kursunu silmək istədiyinizə əminsiniz? Bütün dərslər də silinəcək.');" style="margin:0;">
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

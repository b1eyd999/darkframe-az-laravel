@include('admin._head')

<h1>İstifadəçilər</h1>

<div class="table-wrap">
  <table class="data-table">
    <thead>
      <tr>
        <th>İstifadəçi adı</th>
        <th>E-poçt</th>
        <th>Rol</th>
        <th>Qeydiyyat tarixi</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $u)
        <tr>
          <td><strong>{{ $u->username }}</strong></td>
          <td>{{ $u->email }}</td>
          <td><span class="badge {{ $u->role === 'admin' ? 'badge-admin' : 'badge-user' }}">{{ $u->role }}</span></td>
          <td>{{ $u->created_at }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

@include('admin._footer')

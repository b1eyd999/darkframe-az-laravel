@if (session('success') || session('error'))
<div class="flash-wrap">
  @if (session('success'))
    <div class="flash flash-success">{{ session('success') }}</div>
  @endif
  @if (session('error'))
    <div class="flash flash-error">{{ session('error') }}</div>
  @endif
</div>
@endif

<div class="review-section">
  <h2>Rəylər ({{ $reviewCount }})</h2>

  @auth
    <form method="POST" action="{{ $reviewActionUrl }}" class="review-form">
      @csrf
      <div class="review-form-rating">
        @for ($i = 1; $i <= 5; $i++)
          <label class="rating-star {{ $myReview && $myReview->rating >= $i ? 'filled' : '' }}">
            <input type="radio" name="rating" value="{{ $i }}" {{ $myReview && $myReview->rating == $i ? 'checked' : '' }} required>
            <span>★</span>
          </label>
        @endfor
      </div>
      <textarea name="comment" rows="3" placeholder="Fikrinizi yazın (istəyə bağlı)">{{ $myReview->comment ?? '' }}</textarea>
      <button type="submit" class="btn btn-primary btn-sm">{{ $myReview ? 'Rəyimi yenilə' : 'Rəy bildir' }}</button>
    </form>
    <script>
      document.querySelectorAll('.review-form-rating').forEach(function (picker) {
        var stars = Array.from(picker.querySelectorAll('.rating-star'));
        function paint(upTo) {
          stars.forEach(function (s, i) { s.classList.toggle('filled', i < upTo); });
        }
        stars.forEach(function (star, i) {
          star.addEventListener('click', function () { paint(i + 1); });
        });
      });
    </script>
  @else
    <p class="field-hint review-login-hint"><a href="/login">Daxil olun</a> ki, rəy və reytinq bildirə biləsiniz.</p>
  @endauth

  @if ($reviews->isEmpty())
    <div class="empty-state">Hələ rəy yazılmayıb — ilk rəyi siz yazın.</div>
  @else
    <div class="review-list">
      @foreach ($reviews as $rv)
        <div class="review-item">
          <div class="review-item-head">
            <strong>{{ $rv->user->username }}</strong>
            @include('partials.star-rating', ['rating' => $rv->rating, 'hideLabel' => true])
          </div>
          @if ($rv->comment)
            <p>{{ $rv->comment }}</p>
          @endif
          <span class="review-date">{{ $rv->created_at }}</span>
        </div>
      @endforeach
    </div>
  @endif
</div>

<script>
  // Sayt açıq qaldığı müddətdə serverə "hələ buradayam" siqnalı göndərir ki,
  // admin paneldəki "onlayn istifadəçi" sayı düzgün olsun.
  (function () {
    function ping() {
      fetch('/api/heartbeat', { method: 'POST', keepalive: true }).catch(function () {});
    }
    ping();
    setInterval(ping, 20000);
    document.addEventListener('visibilitychange', function () {
      if (document.visibilityState === 'visible') ping();
    });
  })();
</script>

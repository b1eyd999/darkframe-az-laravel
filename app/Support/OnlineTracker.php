<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;

// Sadə "kim onlayndır" izləyicisi — PHP-nin request-başına-proses modelində
// yaddaşda saxlamaq mümkün olmadığı üçün bütün sessiyaların siyahısı tək bir
// cache açarı altında (JSON massiv kimi) saxlanılır. ONLINE_WINDOW ərzində
// siqnal göndərməyən sessiyalar hər oxunuşda "sweep" ilə təmizlənir.
class OnlineTracker
{
    private const CACHE_KEY = 'online_sessions';
    private const ONLINE_WINDOW = 60; // saniyə

    public static function touch(?string $sessionId, $user): void
    {
        if (!$sessionId) {
            return;
        }
        $sessions = Cache::get(self::CACHE_KEY, []);
        $sessions[$sessionId] = [
            'lastSeen' => time(),
            'username' => $user?->username,
            'role' => $user?->role,
        ];
        Cache::put(self::CACHE_KEY, $sessions);
    }

    private static function sweep(): array
    {
        $cutoff = time() - self::ONLINE_WINDOW;
        $sessions = Cache::get(self::CACHE_KEY, []);
        $sessions = array_filter($sessions, fn ($info) => $info['lastSeen'] >= $cutoff);
        Cache::put(self::CACHE_KEY, $sessions);
        return $sessions;
    }

    public static function getOnlineCount(): int
    {
        return count(self::sweep());
    }

    public static function getOnlineList(): array
    {
        $list = array_map(fn ($info) => [
            'username' => $info['username'],
            'role' => $info['role'],
            'secondsAgo' => max(0, time() - $info['lastSeen']),
        ], array_values(self::sweep()));

        usort($list, fn ($a, $b) => $a['secondsAgo'] <=> $b['secondsAgo']);
        return $list;
    }
}

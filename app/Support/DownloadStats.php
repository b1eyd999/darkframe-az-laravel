<?php

namespace App\Support;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

// Admin paneldəki "satış" (plugin yükləmə) statistikası üçün köməkçi.
//
// Qeyd: saytda hələ qiymət/ödəniş sistemi yoxdur — kurslar və pluginlər
// pulsuzdur. Ona görə burada "satış" plugin yükləmələrinin sayı kimi
// hesablanır (hər uğurlu yükləmə `download_events` cədvəlinə yazılır).
class DownloadStats
{
    // Son `days` gün üçün gündəlik yükləmə sayı (boş günlər 0 kimi göstərilir).
    public static function daily(int $days = 14): array
    {
        $rows = DB::table('download_events')
            ->selectRaw("date(downloaded_at) d, COUNT(*) c")
            ->where('downloaded_at', '>=', Carbon::now()->subDays($days - 1)->startOfDay())
            ->groupBy('d')
            ->pluck('c', 'd');

        $out = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $d = Carbon::now()->subDays($i);
            $key = $d->format('Y-m-d');
            $out[] = ['label' => $d->format('d.m'), 'count' => (int) ($rows[$key] ?? 0)];
        }
        return $out;
    }

    // Son `weeks` həftə üçün (7 günlük "sürüşən" bloklar, bu günə qədər) yükləmə sayı.
    public static function weekly(int $weeks = 8): array
    {
        $totalDays = $weeks * 7;
        $rows = DB::table('download_events')
            ->selectRaw("date(downloaded_at) d, COUNT(*) c")
            ->where('downloaded_at', '>=', Carbon::now()->subDays($totalDays - 1)->startOfDay())
            ->groupBy('d')
            ->pluck('c', 'd');

        $out = [];
        for ($w = $weeks - 1; $w >= 0; $w--) {
            $sum = 0;
            $startLabel = null;
            for ($i = 6; $i >= 0; $i--) {
                $offset = $w * 7 + $i;
                $d = Carbon::now()->subDays($offset);
                $sum += (int) ($rows[$d->format('Y-m-d')] ?? 0);
                if ($i === 6) {
                    $startLabel = $d->format('d.m');
                }
            }
            $out[] = ['label' => $startLabel, 'count' => $sum];
        }
        return $out;
    }

    // Son `months` ay üçün (təqvim ayları üzrə) yükləmə sayı.
    public static function monthly(int $months = 6): array
    {
        $start = Carbon::now()->startOfMonth()->subMonths($months - 1);
        $rows = DB::table('download_events')
            ->selectRaw("strftime('%Y-%m', downloaded_at) m, COUNT(*) c")
            ->where('downloaded_at', '>=', $start)
            ->groupBy('m')
            ->pluck('c', 'm');

        $monthNames = ['Yan', 'Fev', 'Mar', 'Apr', 'May', 'İyn', 'İyl', 'Avq', 'Sen', 'Okt', 'Noy', 'Dek'];
        $out = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $d = Carbon::now()->startOfMonth()->subMonths($i);
            $out[] = [
                'label' => $monthNames[$d->month - 1],
                'count' => (int) ($rows[$d->format('Y-m')] ?? 0),
            ];
        }
        return $out;
    }
}

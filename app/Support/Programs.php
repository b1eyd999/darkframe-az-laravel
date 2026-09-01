<?php

namespace App\Support;

// Kurslar və pluginlər üçün "proqramın adına görə" bölmələşdirmə siyahısı.
//
// Qeyd: nişanlar (badge) real brend loqoları deyil — sadəcə hərf/qısaltma
// və rəngli kvadratdır (məsələn Adobe tətbiqlərinin özünəməxsus loqo
// dizaynını təkrarlamırıq, ona görə brend hüquqları ilə bağlı narahatlıq
// yaratmır). Rənglər saytın öz lime/tünd-yaşıl palitrasından götürülüb.
class Programs
{
    private const PALETTE = [
        '#c6ff1a', '#7fd400', '#3fae1f', '#1f8f4a', '#0e9e78',
        '#2fae8f', '#4a9ecf', '#6f8ecf', '#8c7fd0', '#b06fd0',
        '#d06f9e', '#d0806f', '#cf9e4a', '#a8b83a',
    ];

    private const COURSE_NAMES = [
        'After Effects', 'Premiere Pro', 'Blender', 'Cinema 4D', 'Photoshop',
        'Illustrator', 'Maya', '3ds Max', 'ZBrush', 'Unreal Engine', 'Houdini',
        'Substance Painter', 'Substance Designer', 'Nuke', 'Unity', 'Plasticity 3D',
        'Revit', 'AutoCAD', 'GameDev', 'iClone', 'Mari', 'Procreate',
        'Süni İntellekt (AI)', 'Video Montaj', 'Foto/Video', 'Kino', 'Digər',
    ];

    private const PLUGIN_NAMES = [
        'After Effects', 'Premiere Pro', 'Cinema 4D', 'Maya', '3ds Max', 'Blender',
        'ZBrush', 'Reallusion', 'Illustrator', 'Houdini', 'Unreal Engine', 'Unity',
        'DaVinci Resolve', 'Digər',
    ];

    private static function badgeColor(string $name): string
    {
        $hash = 0;
        foreach (mb_str_split($name) as $char) {
            $hash = ($hash * 31 + mb_ord($char)) & 0xFFFFFFFF;
        }
        return self::PALETTE[$hash % count(self::PALETTE)];
    }

    private static function initials(string $name): string
    {
        $words = array_values(array_filter(preg_split('/[\s\/]+/', str_replace(['(', ')'], '', $name))));
        if (count($words) === 1) {
            return mb_substr($words[0], 0, 2);
        }
        return mb_strtoupper(mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1));
    }

    private static function buildList(array $names): array
    {
        return array_map(fn (string $name) => [
            'name' => $name,
            'tag' => self::initials($name),
            'color' => self::badgeColor($name),
        ], $names);
    }

    public static function courses(): array
    {
        return self::buildList(self::COURSE_NAMES);
    }

    public static function plugins(): array
    {
        return self::buildList(self::PLUGIN_NAMES);
    }
}

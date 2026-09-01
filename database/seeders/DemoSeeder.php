<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\DownloadEvent;
use App\Models\Lesson;
use App\Models\Plugin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// Admin hesabı, nümunə istifadəçi, nümunə kurslar/dərslər və pluginlərlə
// platformanı offline tam kəşf edilə bilən vəziyyətə gətirir. Hər əməliyyat
// ad/e-poçta görə upsert-dir, ona görə təkrar işə salmaq təhlükəsizdir.
class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@platform.local'],
            ['username' => 'admin', 'password' => Hash::make('admin123'), 'role' => 'admin']
        );

        User::firstOrCreate(
            ['email' => 'user@platform.local'],
            ['username' => 'demo_istifadeci', 'password' => Hash::make('user1234'), 'role' => 'user']
        );

        $vfx = Course::firstOrCreate(
            ['title' => 'VFX Artist 2.0'],
            [
                'description' => 'Filmlər, musiqi klipləri, reklam və bloqlar üçün peşəkar vizual effektlər (VFX) yaratmağı öyrənin. Çəkilişdən quraşdırmaya, keying-dən 3D-yə qədər tam təcrübə.',
                'category' => 'Vizual Effektlər',
                'thumbnail' => '/thumbnails/vfx-course.jpg',
                'level' => 'Başlanğıcdan irəli səviyyəyə',
                'program' => 'Video Montaj',
                'created_by' => $admin->id,
            ]
        );
        $this->addLesson($vfx, 'Giriş: Kurs haqqında', '/videos/vfx-lesson-1.mp4', '08:00', 1);
        $this->addLesson($vfx, 'Kamera ilə düzgün çəkiliş', '/videos/vfx-lesson-2.mp4', '12:30', 2);
        $this->addLesson($vfx, 'VFX üçün işıqlandırma əsasları', '/videos/vfx-lesson-3.mp4', '15:45', 3);

        $ae = Course::firstOrCreate(
            ['title' => 'After Effects Ustalığı'],
            [
                'description' => 'Compositing, keying, tracking və vizual effektlərin inteqrasiyası daxil olmaqla After Effects-də irəli səviyyə bacarıqlar.',
                'category' => 'Montaj və Kompozisiya',
                'thumbnail' => '/thumbnails/ae-course.jpg',
                'level' => 'Orta səviyyə',
                'program' => 'After Effects',
                'created_by' => $admin->id,
            ]
        );
        $this->addLesson($ae, 'After Effects interfeysi', '/videos/ae-lesson-1.mp4', '10:15', 1);
        $this->addLesson($ae, 'Keying və Tracking texnikaları', '/videos/ae-lesson-2.mp4', '18:20', 2);

        $blender = Course::firstOrCreate(
            ['title' => 'Blender Emalatxanası'],
            [
                'description' => '3D modelləşdirmə, hissəcik simulyasiyası, xarakter animasiyası və mühit dizaynı üzrə praktiki emalatxana.',
                'category' => '3D Qrafika',
                'thumbnail' => '/thumbnails/blender-course.jpg',
                'level' => 'İrəli səviyyə',
                'program' => 'Blender',
                'created_by' => $admin->id,
            ]
        );
        $this->addLesson($blender, '3D modelləşdirməyə giriş', '/videos/blender-lesson-1.mp4', '20:00', 1);

        $keying = Plugin::firstOrCreate(
            ['name' => 'Keying Pro'],
            [
                'description' => 'Adobe After Effects üçün professional green screen (chroma key) plugini.',
                'compatible_program' => 'After Effects',
                'version' => '1.0',
                'icon' => '/icons/plugin-keying.png',
                'file_path' => '/uploads/plugins/keying-pro-v1.0.zip',
                'file_original_name' => 'keying-pro-v1.0.zip',
                'file_size' => 313,
                'uploaded_by' => $admin->id,
            ]
        );

        $particle = Plugin::firstOrCreate(
            ['name' => 'Particle FX'],
            [
                'description' => 'Blender üçün hissəcik (particle) simulyasiya alətləri toplusu.',
                'compatible_program' => 'Blender',
                'version' => '2.1',
                'icon' => '/icons/plugin-particles.png',
                'file_path' => '/uploads/plugins/particle-fx-v2.1.zip',
                'file_original_name' => 'particle-fx-v2.1.zip',
                'file_size' => 308,
                'uploaded_by' => $admin->id,
            ]
        );

        $colorMatch = Plugin::firstOrCreate(
            ['name' => 'Color Match'],
            [
                'description' => 'DaVinci Resolve üçün avtomatik rəng uyğunlaşdırma plugini.',
                'compatible_program' => 'DaVinci Resolve',
                'version' => '1.3',
                'icon' => '/icons/plugin-default.png',
                'file_path' => '/uploads/plugins/color-match-v1.3.zip',
                'file_original_name' => 'color-match-v1.3.zip',
                'file_size' => 308,
                'uploaded_by' => $admin->id,
            ]
        );

        // Admin paneldəki "satış" qrafiklərinin boş görünməməsi üçün son ~45
        // günə paylanmış nümunə yükləmə tarixçəsi (yalnız ilk seed-də).
        if (DownloadEvent::count() === 0) {
            $demoUser = User::where('email', 'user@platform.local')->first();
            $pluginIds = [$keying->id, $particle->id, $colorMatch->id];

            for ($daysAgo = 44; $daysAgo >= 0; $daysAgo--) {
                $activity = $daysAgo <= 7 ? 3 : ($daysAgo <= 20 ? 2 : 1);
                $eventsToday = (mt_rand() / mt_getrandmax()) < 0.75 ? $activity : 0;
                for ($n = 0; $n < $eventsToday; $n++) {
                    $pluginId = $pluginIds[array_rand($pluginIds)];
                    $hour = mt_rand(1, 20);
                    DownloadEvent::create([
                        'plugin_id' => $pluginId,
                        'user_id' => $demoUser->id,
                        'downloaded_at' => now()->subDays($daysAgo)->subHours($hour),
                    ]);
                }
            }

            foreach (Plugin::all() as $plugin) {
                $plugin->update(['downloads' => $plugin->downloadEvents()->count()]);
            }
        }

        $this->command->info('Seed tamamlandı.');
        $this->command->info('Admin girişi: admin@platform.local / admin123');
        $this->command->info('İstifadəçi girişi: user@platform.local / user1234');
    }

    private function addLesson(Course $course, string $title, string $videoUrl, string $duration, int $order): void
    {
        Lesson::firstOrCreate(
            ['course_id' => $course->id, 'title' => $title],
            ['video_url' => $videoUrl, 'duration' => $duration, 'sort_order' => $order]
        );
    }
}

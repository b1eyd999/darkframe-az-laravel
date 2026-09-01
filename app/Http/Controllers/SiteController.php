<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseReview;
use App\Models\Plugin;
use App\Models\PluginReview;
use App\Support\OnlineTracker;
use App\Support\Programs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SiteController extends Controller
{
    public function home()
    {
        $courses = Course::orderByDesc('created_at')->get();
        $plugins = Plugin::orderByDesc('created_at')->limit(3)->get();
        return view('home', ['title' => 'Ana səhifə', 'courses' => $courses, 'plugins' => $plugins]);
    }

    public function courses(Request $request)
    {
        $selectedProgram = $request->query('program', '');
        $query = Course::orderByDesc('created_at');
        if ($selectedProgram) {
            $query->where('program', $selectedProgram);
        }
        $courses = $query->get();

        $counts = Course::whereNotNull('program')->where('program', '!=', '')
            ->selectRaw('program, COUNT(*) c')->groupBy('program')->pluck('c', 'program');

        return view('courses.index', [
            'title' => 'Video Kurslar',
            'courses' => $courses,
            'programs' => Programs::courses(),
            'programCounts' => $counts,
            'selectedProgram' => $selectedProgram,
        ]);
    }

    public function courseShow(Course $course)
    {
        $course->increment('views');

        $reviews = $course->reviews()->with('user')->orderByDesc('created_at')->get();
        $myReview = Auth::check() ? $course->reviews()->where('user_id', Auth::id())->first() : null;

        return view('courses.show', [
            'title' => $course->title,
            'course' => $course,
            'lessons' => $course->lessons,
            'avgRating' => (float) $course->reviews()->avg('rating'),
            'reviewCount' => $course->reviews()->count(),
            'reviews' => $reviews,
            'myReview' => $myReview,
        ]);
    }

    public function courseReview(Request $request, Course $course)
    {
        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string'],
        ]);

        CourseReview::updateOrCreate(
            ['course_id' => $course->id, 'user_id' => Auth::id()],
            ['rating' => $data['rating'], 'comment' => trim($data['comment'] ?? '')]
        );

        return redirect("/courses/{$course->id}")->with('success', 'Rəyiniz üçün təşəkkürlər!');
    }

    public function plugins(Request $request)
    {
        $selectedProgram = $request->query('program', '');
        $query = Plugin::orderByDesc('created_at');
        if ($selectedProgram) {
            $query->where('compatible_program', $selectedProgram);
        }
        $plugins = $query->withCount('reviews')->withAvg('reviews', 'rating')->get();

        $counts = Plugin::whereNotNull('compatible_program')->where('compatible_program', '!=', '')
            ->selectRaw('compatible_program, COUNT(*) c')->groupBy('compatible_program')->pluck('c', 'compatible_program');

        return view('plugins.index', [
            'title' => 'Pluginlər',
            'plugins' => $plugins,
            'programs' => Programs::plugins(),
            'programCounts' => $counts,
            'selectedProgram' => $selectedProgram,
        ]);
    }

    public function pluginShow(Plugin $plugin)
    {
        $reviews = $plugin->reviews()->with('user')->orderByDesc('created_at')->get();
        $myReview = Auth::check() ? $plugin->reviews()->where('user_id', Auth::id())->first() : null;

        return view('plugins.show', [
            'title' => $plugin->name,
            'plugin' => $plugin,
            'avgRating' => (float) $plugin->reviews()->avg('rating'),
            'reviewCount' => $plugin->reviews()->count(),
            'reviews' => $reviews,
            'myReview' => $myReview,
        ]);
    }

    public function pluginReview(Request $request, Plugin $plugin)
    {
        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string'],
        ]);

        PluginReview::updateOrCreate(
            ['plugin_id' => $plugin->id, 'user_id' => Auth::id()],
            ['rating' => $data['rating'], 'comment' => trim($data['comment'] ?? '')]
        );

        return redirect("/plugins/{$plugin->id}")->with('success', 'Rəyiniz üçün təşəkkürlər!');
    }

    public function pluginDownload(Plugin $plugin)
    {
        $filePath = public_path($plugin->file_path);
        if (!file_exists($filePath)) {
            return redirect('/plugins')->with('error', 'Fayl serverdə tapılmadı.');
        }

        $plugin->increment('downloads');
        $plugin->downloadEvents()->create(['user_id' => Auth::id()]);

        return response()->download($filePath, $plugin->file_original_name ?: basename($filePath));
    }

    public function heartbeat(Request $request)
    {
        OnlineTracker::touch($request->session()->getId(), $request->user());
        return response()->json(['ok' => true]);
    }
}

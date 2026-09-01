<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Support\Programs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::orderByDesc('created_at')->get();
        return view('admin.courses.index', ['title' => 'Kursların idarəsi', 'courses' => $courses]);
    }

    public function create()
    {
        return view('admin.courses.form', ['title' => 'Yeni Kurs', 'course' => null, 'programs' => Programs::courses()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['title' => ['required', 'string']]);

        $thumbnail = $this->storeThumbnail($request) ?? '/thumbnails/vfx-course.jpg';

        $course = Course::create([
            'title' => $data['title'],
            'description' => $request->input('description', ''),
            'category' => $request->input('category', ''),
            'thumbnail' => $thumbnail,
            'level' => $request->input('level', 'Başlanğıc'),
            'program' => $request->input('program') ?: null,
            'created_by' => Auth::id(),
        ]);

        return redirect('/admin/courses')->with('success', "\"{$course->title}\" kursu əlavə edildi.");
    }

    public function edit(Course $course)
    {
        return view('admin.courses.form', [
            'title' => 'Kursu redaktə et',
            'course' => $course,
            'lessons' => $course->lessons,
            'programs' => Programs::courses(),
        ]);
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate(['title' => ['required', 'string']]);

        $thumbnail = $this->storeThumbnail($request) ?? $course->thumbnail;

        $course->update([
            'title' => $data['title'],
            'description' => $request->input('description', ''),
            'category' => $request->input('category', ''),
            'thumbnail' => $thumbnail,
            'level' => $request->input('level', 'Başlanğıc'),
            'program' => $request->input('program') ?: null,
        ]);

        return redirect('/admin/courses')->with('success', "\"{$course->title}\" kursu yeniləndi.");
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect('/admin/courses')->with('success', "\"{$course->title}\" kursu silindi.");
    }

    public function storeLesson(Request $request, Course $course)
    {
        $data = $request->validate(['title' => ['required', 'string']]);

        $maxOrder = (int) $course->lessons()->max('sort_order');

        Lesson::create([
            'course_id' => $course->id,
            'title' => $data['title'],
            'video_url' => $request->input('video_url', ''),
            'duration' => $request->input('duration', ''),
            'sort_order' => $maxOrder + 1,
        ]);

        return redirect("/admin/courses/{$course->id}/edit")->with('success', 'Dərs əlavə edildi.');
    }

    public function destroyLesson(Course $course, Lesson $lesson)
    {
        if ($lesson->course_id === $course->id) {
            $lesson->delete();
        }
        return redirect("/admin/courses/{$course->id}/edit")->with('success', 'Dərs silindi.');
    }

    private function storeThumbnail(Request $request): ?string
    {
        if (!$request->hasFile('thumbnail_file')) {
            return null;
        }
        $file = $request->file('thumbnail_file');
        $safe = preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
        $filename = time() . '-' . $safe;
        $file->move(public_path('uploads/thumbnails'), $filename);
        return '/uploads/thumbnails/' . $filename;
    }
}

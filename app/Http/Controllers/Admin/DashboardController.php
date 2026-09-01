<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Plugin;
use App\Models\User;
use App\Support\OnlineTracker;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'userCount' => User::count(),
            'courseCount' => Course::count(),
            'lessonCount' => Lesson::count(),
            'pluginCount' => Plugin::count(),
            'totalDownloads' => (int) Plugin::sum('downloads'),
        ];

        return view('admin.dashboard', [
            'title' => 'Admin Panel',
            'stats' => $stats,
            'onlineCount' => OnlineTracker::getOnlineCount(),
        ]);
    }
}

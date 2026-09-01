<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Plugin;
use App\Models\User;
use App\Support\DownloadStats;
use App\Support\OnlineTracker;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index()
    {
        $stats = [
            'userCount' => User::count(),
            'adminCount' => User::where('role', 'admin')->count(),
            'courseCount' => Course::count(),
            'lessonCount' => Lesson::count(),
            'pluginCount' => Plugin::count(),
            'totalDownloads' => (int) Plugin::sum('downloads'),
            'newUsersWeek' => User::where('created_at', '>=', now()->subDays(7))->count(),
        ];

        $topPlugins = Plugin::orderByDesc('downloads')->limit(5)->get(['name', 'downloads']);
        $topCourses = Course::orderByDesc('views')->limit(5)->get(['title', 'views']);
        $recentUsers = User::orderByDesc('created_at')->limit(6)->get(['username', 'email', 'role', 'created_at']);
        $onlineList = OnlineTracker::getOnlineList();

        $daily = DownloadStats::daily(14);
        $weekly = DownloadStats::weekly(8);
        $monthly = DownloadStats::monthly(6);
        $sales = [
            'today' => end($daily)['count'],
            'thisWeek' => array_sum(array_column(array_slice($daily, -7), 'count')),
            'thisMonth' => end($monthly)['count'],
            'daily' => $daily,
            'weekly' => $weekly,
            'monthly' => $monthly,
        ];

        return view('admin.stats', [
            'title' => 'Statistika',
            'stats' => $stats,
            'topPlugins' => $topPlugins,
            'topCourses' => $topCourses,
            'recentUsers' => $recentUsers,
            'onlineList' => $onlineList,
            'onlineCount' => count($onlineList),
            'sales' => $sales,
        ]);
    }

    public function online(Request $request)
    {
        $list = OnlineTracker::getOnlineList();
        return response()->json(['count' => count($list), 'list' => $list]);
    }
}

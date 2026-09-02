<?php

use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PluginController as AdminPluginController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/verify-email', [AuthController::class, 'showVerify']);
Route::post('/verify-email', [AuthController::class, 'verify']);
Route::post('/verify-email/resend', [AuthController::class, 'resendVerification']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/', [SiteController::class, 'home']);

Route::get('/courses', [SiteController::class, 'courses']);
Route::get('/courses/{course}', [SiteController::class, 'courseShow'])->middleware('auth');
Route::post('/courses/{course}/review', [SiteController::class, 'courseReview'])->middleware('auth');

Route::get('/plugins', [SiteController::class, 'plugins']);
Route::get('/plugins/{plugin}', [SiteController::class, 'pluginShow']);
Route::post('/plugins/{plugin}/review', [SiteController::class, 'pluginReview'])->middleware('auth');
Route::get('/plugins/{plugin}/download', [SiteController::class, 'pluginDownload'])->middleware('auth');

Route::post('/api/heartbeat', [SiteController::class, 'heartbeat']);

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/courses', [AdminCourseController::class, 'index']);
    Route::get('/courses/new', [AdminCourseController::class, 'create']);
    Route::post('/courses', [AdminCourseController::class, 'store']);
    Route::get('/courses/{course}/edit', [AdminCourseController::class, 'edit']);
    Route::post('/courses/{course}', [AdminCourseController::class, 'update']);
    Route::post('/courses/{course}/delete', [AdminCourseController::class, 'destroy']);
    Route::post('/courses/{course}/lessons', [AdminCourseController::class, 'storeLesson']);
    Route::post('/courses/{course}/lessons/{lesson}/delete', [AdminCourseController::class, 'destroyLesson']);

    Route::get('/plugins', [AdminPluginController::class, 'index']);
    Route::get('/plugins/new', [AdminPluginController::class, 'create']);
    Route::post('/plugins', [AdminPluginController::class, 'store']);
    Route::get('/plugins/{plugin}/edit', [AdminPluginController::class, 'edit']);
    Route::post('/plugins/{plugin}', [AdminPluginController::class, 'update']);
    Route::post('/plugins/{plugin}/delete', [AdminPluginController::class, 'destroy']);

    Route::get('/stats', [StatsController::class, 'index']);
    Route::get('/stats/online.json', [StatsController::class, 'online']);

    Route::get('/users', [AdminUserController::class, 'index']);
});

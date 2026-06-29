<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KpiController;
use App\Http\Controllers\KpiSsoController;
use App\Http\Controllers\RecruitmentController;
use App\Http\Controllers\NextcloudController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;

// Root page should redirect directly to the login screen.
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth routes (login, register, logout)
require __DIR__.'/auth.php';

// Protected routes
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/company-profile', [DashboardController::class, 'companyProfile'])->name('company.profile');
    Route::get('/system-status', [DashboardController::class, 'systemStatus'])->name('system.status');

    // KPI Marketing
    Route::get('/kpi/sso', [KpiSsoController::class, 'login'])->name('kpi.sso.login');
    Route::get('/kpi/dashboard', [KpiController::class, 'dashboard'])->name('kpi.dashboard');
    Route::get('/kpi/report', [KpiController::class, 'report'])->name('kpi.report');
    Route::get('/kpi/sdm', [KpiController::class, 'sdm'])->name('kpi.sdm');
    Route::get('/kpi/setting', [KpiController::class, 'setting'])->name('kpi.setting');
    Route::resource('kpi', KpiController::class);

    // Recruitment
    Route::resource('recruitment', RecruitmentController::class);

    // Nextcloud (file browser)
    Route::get('/nextcloud', [NextcloudController::class, 'index'])->name('nextcloud.index');
    Route::post('/nextcloud/upload', [NextcloudController::class, 'upload'])->name('nextcloud.upload');

    // Additional modules and integrated services
    Route::get('/news', [\App\Http\Controllers\NewsController::class, 'index'])->name('news.index');

    // OHLC Market Data
    Route::resource('ohlc', \App\Http\Controllers\OhlcController::class);

    // Announcements
    Route::resource('announcements', AnnouncementController::class);

    // User management (admin only) — protected by UserController middleware
    Route::resource('users', UserController::class)->except(['show']);

    // Calendar
    Route::resource('calendar', CalendarController::class);

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.center');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/avatar', [ProfileController::class, 'destroyAvatar'])->name('profile.avatar.destroy');

});

<?php

namespace App\Providers;

use App\Models\ModuleStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View as ViewClass;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function (ViewClass $view): void {
            $systemStatuses = ModuleStatus::statuses();
            $notifications = [];
            $unreadCount = 0;

            $hasKpiAccess = false;
            $kpiRole = null;

            if (Auth::check()) {
                /** @var \App\Models\User $user */
                $user = Auth::user();

                // Framework notifications mapped to simple objects for view
                $notifications = $user->notifications()
                    ->orderByDesc('created_at')
                    ->limit(5)
                    ->get()
                    ->map(function ($notification) {
                        return (object) array_merge(
                            is_array($notification->data) ? $notification->data : [],
                            [
                                'id' => $notification->id,
                                'created_at' => $notification->created_at,
                                'read_at' => $notification->read_at,
                            ]
                        );
                    });

                $unreadCount = $user->unreadNotifications()->count();
                $hasKpiAccess = $user->hasKpiAccount();
                $kpiRole = $user->getKpiRole();
            }

            $view->with([
                'systemStatuses' => $systemStatuses,
                'layoutNotifications' => $notifications,
                'unreadNotificationCount' => $unreadCount,
                'hasKpiAccess' => $hasKpiAccess,
                'kpiRole' => $kpiRole,
            ]);
        });
    }
}

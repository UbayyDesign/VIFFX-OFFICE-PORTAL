<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display all notifications
     */
    public function index(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $notifications = $user->notifications()
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($n) {
                return (object) array_merge(
                    is_array($n->data) ? $n->data : [],
                    [
                        'id' => $n->id,
                        'created_at' => $n->created_at,
                        'read_at' => $n->read_at,
                    ]
                );
            });

        return view('notifications.center', [
            'page' => [
                'title' => 'Pusat Notifikasi',
                'eyebrow' => 'Kelola Notifikasi',
                'description' => 'Lihat semua notifikasi sistem, update penting, dan pengingat dari VIFFX Portal.',
                'status_label' => 'Semua Notifikasi',
                'status_color' => 'bg-blue-400',
            ],
            'notifications' => $notifications,
        ]);
    }

    /**
     * Mark a notification as read
     */
    public function markAsRead(string $id): RedirectResponse
    {
        $user = Auth::user();

        $notification = DatabaseNotification::query()
            ->where('id', $id)
            ->where('notifiable_id', $user->id)
            ->firstOrFail();

        if (is_null($notification->read_at)) {
            $notification->update(['read_at' => now()]);
        }

        return back();
    }
}

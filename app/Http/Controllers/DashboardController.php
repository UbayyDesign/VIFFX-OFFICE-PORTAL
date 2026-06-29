<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\CalendarEvent;
use App\Models\Candidate;
use App\Models\ModuleStatus;
use App\Models\Report;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get system module statuses
     */
    protected function systemStatuses(): array
    {
        return ModuleStatus::statuses();
    }

    /**
     * Display the main dashboard
     */
    public function index(): View
    {
        $systemStatuses = $this->systemStatuses();

        $stats = [
            'total_users' => User::count(),
            'total_teams' => Team::count(),
            'total_reports' => Report::count(),
            'total_candidates' => Candidate::count(),
        ];

        $announcements = Announcement::latest()->limit(3)->get();
        $todayEvents = CalendarEvent::whereDate('start_time', today())->get();

        return view('dashboard.index', compact('systemStatuses', 'stats', 'announcements', 'todayEvents'
        ));
    }

    /**
     * Display system status monitoring page
     */
    public function systemStatus(): View
    {
        $systemStatuses = $this->systemStatuses();

        $cards = [
            ['label' => 'Total Systems', 'value' => count($systemStatuses), 'detail' => 'Sistem yang dipantau'],
            ['label' => 'Online', 'value' => count(array_filter($systemStatuses, fn($s) => strtolower($s['status']) === 'online')), 'detail' => 'Sistem berjalan normal'],
            ['label' => 'Warning', 'value' => count(array_filter($systemStatuses, fn($s) => strtolower($s['status']) === 'warning')), 'detail' => 'Sistem dengan masalah'],
            ['label' => 'Offline', 'value' => count(array_filter($systemStatuses, fn($s) => strtolower($s['status']) === 'offline')), 'detail' => 'Sistem tidak aktif'],
        ];

        $items = array_map(function ($status) {
            $statusClass = match (strtolower($status['status'])) {
                'online' => 'bg-emerald-400/10 text-emerald-300',
                'warning' => 'bg-amber-400/10 text-amber-300',
                default => 'bg-rose-400/10 text-rose-300',
            };

            return [
                'title' => $status['name'],
                'meta' => 'Monitoring • ' . now()->format('H:i \W\I\B'),
                'badge' => ucfirst($status['status']),
                'badge_class' => $statusClass,
                'description' => "Status: {$status['status']}. Response: {$status['response_time']}",
            ];
        }, $systemStatuses);

        return view('modules.module-page', [
            'page' => [
                'title' => 'System Status',
                'eyebrow' => 'Status Server',
                'description' => 'Pantau status layanan internal perusahaan VIFX secara real-time. Setiap modul dipantau dengan sistem monitoring otomatis.',
                'status_label' => 'Live Monitoring',
                'status_color' => 'bg-emerald-400',
            ],
            'cards' => $cards,
            'items' => $items,
        ]);
    }
}

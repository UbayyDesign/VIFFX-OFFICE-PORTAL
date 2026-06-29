<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        return view('modules.module-page', [
            'page' => [
                'title' => 'Calendar',
                'eyebrow' => 'Jadwal & Event',
                'description' => 'Lihat agenda, event, dan meeting internal yang tersedia dalam tampilan kalender sederhana.',
                'status_label' => 'Online',
                'status_color' => 'bg-emerald-400',
                'live_label' => 'Real-time clock',
            ],
            'cards' => [
                ['label' => 'Event', 'value' => '14', 'detail' => 'Event yang sudah dijadwalkan'],
                ['label' => 'Meeting', 'value' => '6', 'detail' => 'Rapat internal untuk minggu ini'],
                ['label' => 'Reminder', 'value' => '4', 'detail' => 'Pengingat yang akan datang'],
                ['label' => 'Attendance', 'value' => '82%', 'detail' => 'Partisipasi rata-rata tim'],
            ],
            'items' => [
                ['title' => 'Weekly Sync', 'meta' => 'Monday 09.00', 'badge' => 'Scheduled', 'badge_class' => 'bg-sky-400/10 text-sky-300', 'description' => 'Rapat sinergi departemen untuk menjadwalkan prioritas minggu.'],
                ['title' => 'Townhall', 'meta' => 'Wednesday 13.30', 'badge' => 'Confirmed', 'badge_class' => 'bg-emerald-400/10 text-emerald-300', 'description' => 'Townhall bulanan dan update target performa perusahaan.'],
            ],
        ]);
    }

    public function create() { return $this->index(); }
    public function store(Request $request) { return redirect()->route('calendar.index'); }
    public function show($id) { return $this->index(); }
    public function edit($id) { return $this->index(); }
    public function update(Request $request, $id) { return redirect()->route('calendar.index'); }
    public function destroy($id) { return redirect()->route('calendar.index'); }
}

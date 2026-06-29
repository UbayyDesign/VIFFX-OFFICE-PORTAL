<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecruitmentController extends Controller
{
    public function index()
    {
        return view('modules.module-page', [
            'page' => [
                'title' => 'Recruitment Database',
                'eyebrow' => 'Modul HR',
                'description' => 'Kelola kandidat, jadwal interview, dan status rekrutmen secara terpusat dan terstruktur.',
                'status_label' => 'Online',
                'status_color' => 'bg-emerald-400',
            ],
            'cards' => [
                ['label' => 'Pelamar', 'value' => '54', 'detail' => 'Jumlah pelamar aktif bulan ini'],
                ['label' => 'Interview', 'value' => '12', 'detail' => 'Jadwal interview yang sudah disusun'],
                ['label' => 'Status', 'value' => '85%', 'detail' => 'Presentase kandidat yang sudah diproses'],
                ['label' => 'Hiring', 'value' => '6', 'detail' => 'Kandidat yang lolos tahap final'],
            ],
            'items' => [
                ['title' => 'Interview Schedule', 'meta' => '10.00 WIB', 'badge' => 'Planned', 'badge_class' => 'bg-amber-400/10 text-amber-300', 'description' => 'Penjadwalan interview untuk 3 kandidat posisi teknis.'],
                ['title' => 'Candidate Notes', 'meta' => '09.20 WIB', 'badge' => 'Updated', 'badge_class' => 'bg-violet-400/10 text-violet-300', 'description' => 'Catatan interview diperbarui untuk kandidat baru.'],
            ],
        ]);
    }

    public function create() { return $this->index(); }
    public function store(Request $request) { return redirect()->route('recruitment.index'); }
    public function show($id) { return $this->index(); }
    public function edit($id) { return $this->index(); }
    public function update(Request $request, $id) { return redirect()->route('recruitment.index'); }
    public function destroy($id) { return redirect()->route('recruitment.index'); }
}

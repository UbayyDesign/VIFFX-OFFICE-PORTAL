<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NextcloudController extends Controller
{
    public function index()
    {
        return view('modules.module-page', [
            'page' => [
                'title' => 'Nextcloud Storage',
                'eyebrow' => 'File & Dokumen',
                'description' => 'Akses file, dokumen, dan arsip kantor dalam satu layanan terpusat.',
                'status_label' => 'Online',
                'status_color' => 'bg-emerald-400',
            ],
            'cards' => [
                ['label' => 'Folder', 'value' => '18', 'detail' => 'Folder aktif yang bisa dibuka'],
                ['label' => 'Dokumen', 'value' => '246', 'detail' => 'Dokumen tersimpan di storage'],
                ['label' => 'Upload', 'value' => '9', 'detail' => 'File yang baru diupload hari ini'],
                ['label' => 'Size', 'value' => '1.2 GB', 'detail' => 'Total ukuran penyimpanan terpakai'],
            ],
            'items' => [
                ['title' => 'Folder Finance', 'meta' => 'Shared', 'badge' => 'Available', 'badge_class' => 'bg-sky-400/10 text-sky-300', 'description' => 'Dokumen keuangan dan laporan bulanan siap diakses.'],
                ['title' => 'Archive HR', 'meta' => 'Read-only', 'badge' => 'Protected', 'badge_class' => 'bg-violet-400/10 text-violet-300', 'description' => 'Arsip data karyawan dan dokumen onboarding.'],
            ],
        ]);
    }

    public function upload(Request $request) { return redirect()->route('nextcloud.index'); }
}

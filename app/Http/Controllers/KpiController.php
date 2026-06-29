<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use App\Models\Report;
use App\Models\ReportDetail;
use App\Models\Sdm;

class KpiController extends Controller
{
    public function index()
    {
        return $this->renderKpiPage([
            'title' => 'KPI Dashboard',
            'eyebrow' => 'KPI',
            'description' => 'Halaman utama KPI dengan ringkasan performa dummy sementara.',
            'status_label' => 'Online',
            'status_color' => 'bg-emerald-400',
        ]);
    }

    public function dashboard()
    {
        // read-only summary from KPI database
        try {
            $totalReports = Report::query()->count();
            $totalReportDetails = ReportDetail::query()->count();
            $totalNewData = (int) Report::query()->sum('total_new_data');
            $sdmCount = Sdm::query()->count();

            $statusStats = ReportDetail::query()
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get()
                ->pluck('total', 'status')
                ->toArray();
        } catch (\Exception $e) {
            // on failure, fallback to zeros and keep Portal stable
            $totalReports = 0;
            $totalReportDetails = 0;
            $totalNewData = 0;
            $sdmCount = 0;
            $statusStats = [];
        }

        $cards = [
            ['label' => 'Total Reports', 'value' => number_format($totalReports), 'detail' => 'Jumlah laporan terdaftar'],
            ['label' => 'Total Report Details', 'value' => number_format($totalReportDetails), 'detail' => 'Jumlah baris detail laporan'],
            ['label' => 'Total New Data', 'value' => number_format($totalNewData), 'detail' => 'Jumlah penambahan data (sum)'],
            ['label' => 'Total SDM', 'value' => number_format($sdmCount), 'detail' => 'Jumlah entri SDM'],
        ];

        $items = [];
        foreach ($statusStats as $status => $count) {
            $items[] = [
                'title' => $status,
                'meta' => $count . ' rows',
                'badge' => $status,
                'description' => 'Jumlah record dengan status ' . $status,
            ];
        }

        $page = [
            'title' => 'Dashboard KPI',
            'eyebrow' => 'KPI',
            'description' => 'Ringkasan KPI (read-only) yang diambil dari database KPI.',
            'status_label' => 'Online',
            'status_color' => 'bg-emerald-400',
        ];

        return view('modules.module-page', [
            'page' => $page,
            'cards' => $cards,
            'items' => $items,
        ]);
    }

    public function report(Request $request)
    {
        // Read-only list of reports from KPI DB with pagination and optional date filter
        $from = $request->query('from');
        $to = $request->query('to');

        try {
            $query = Report::query()->orderBy('report_date', 'desc');

            if ($from && $to) {
                $query->whereBetween('report_date', [$from, $to]);
            } elseif ($from) {
                $query->where('report_date', '>=', $from);
            } elseif ($to) {
                $query->where('report_date', '<=', $to);
            }

            $reports = $query->paginate(15)->withQueryString();
        } catch (\Exception $e) {
            // If KPI DB is missing/unreachable, return an empty paginator so Portal stays up
            $reports = new LengthAwarePaginator([], 0, 15, 1, [
                'path' => request()->url(),
                'query' => request()->query(),
            ]);
        }

        $page = [
            'title' => 'Report',
            'eyebrow' => 'Laporan KPI',
            'description' => 'Daftar laporan KPI (read-only) yang diambil dari database KPI.',
            'status_label' => 'Report Ready',
            'status_color' => 'bg-sky-400',
        ];

        return view('modules.kpi-report-list', [
            'page' => $page,
            'reports' => $reports,
            'from' => $from,
            'to' => $to,
        ]);
    }

    public function sdm(Request $request)
    {
        $from = $request->query('from');
        $to = $request->query('to');
        $type = $request->query('type');

        try {
            $query = Sdm::query()->orderBy('tanggal_masuk', 'desc');

            if ($from && $to) {
                $query->whereBetween('tanggal_masuk', [$from, $to]);
            } elseif ($from) {
                $query->where('tanggal_masuk', '>=', $from);
            } elseif ($to) {
                $query->where('tanggal_masuk', '<=', $to);
            }

            if (in_array($type, ['MGM', 'RO'])) {
                $query->where('tipe', $type);
            }

            $sdms = $query->paginate(15)->withQueryString();
        } catch (\Exception $e) {
            $sdms = new LengthAwarePaginator([], 0, 15, 1, [
                'path' => request()->url(),
                'query' => request()->query(),
            ]);
        }

        $page = [
            'title' => 'SDM',
            'eyebrow' => 'Sumber Daya Manusia',
            'description' => 'Daftar SDM KPI (read-only) yang diambil dari database KPI.',
            'status_label' => 'HR Ready',
            'status_color' => 'bg-purple-400',
        ];

        return view('modules.kpi-sdm-list', [
            'page' => $page,
            'sdms' => $sdms,
            'from' => $from,
            'to' => $to,
            'type' => $type,
        ]);
    }

    public function setting()
    {
        return $this->renderKpiPage([
            'title' => 'Setting',
            'eyebrow' => 'Pengaturan KPI',
            'description' => 'Halaman pengaturan KPI placeholder untuk navigasi modul.',
            'status_label' => 'Config',
            'status_color' => 'bg-yellow-400',
        ]);
    }

    public function create() { return $this->index(); }
    public function store(Request $request) { return redirect()->route('kpi.index'); }
    public function show($id) { return $this->index(); }
    public function edit($id) { return $this->index(); }
    public function update(Request $request, $id) { return redirect()->route('kpi.index'); }
    public function destroy($id) { return redirect()->route('kpi.index'); }

    private function renderKpiPage(array $page)
    {
        return view('modules.module-page', [
            'page' => $page,
            'cards' => [
                ['label' => 'Target', 'value' => '92%', 'detail' => 'Target KPI bulan ini tercapai dengan performa stabil.'],
                ['label' => 'Lead', 'value' => '128', 'detail' => 'Lead baru dari kampanye digital.'],
                ['label' => 'ROI', 'value' => '3.4x', 'detail' => 'Efisiensi belanja iklan meningkat.'],
                ['label' => 'Konversi', 'value' => '18%', 'detail' => 'Rasio konversi dari lead ke closing.'],
            ],
            'items' => [
                ['title' => 'Campaign Summary', 'meta' => '08.30 WIB', 'badge' => 'Ready', 'badge_class' => 'bg-emerald-400/10 text-emerald-300', 'description' => 'Kampanye utama berjalan normal dengan performa stabil.'],
                ['title' => 'Data Source', 'meta' => '07.45 WIB', 'badge' => 'Synced', 'badge_class' => 'bg-sky-400/10 text-sky-300', 'description' => 'Sinkronisasi data dari CRM dan media sosial berhasil.'],
            ],
        ]);
    }
}

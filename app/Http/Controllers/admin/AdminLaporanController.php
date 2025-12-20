<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Klaster;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;
use App\Exports\LaporanDesaExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class AdminLaporanController extends Controller
{
    /**
     * 📊 Level 1: Rekap semua desa dengan pagination dan search
     */
    public function index(Request $request)
    {
        $tahun = $request->get('tahun', now()->year);
        $bulan = $request->get('bulan', now()->format('F'));
        $search = $request->get('search', '');

        // Query dengan search dan pagination
        $query = Desa::withCount([
            'penilaians as total_pending' => fn ($q) => $q->where('status', 'pending')
                ->where('tahun', $tahun)
                ->where('bulan', $bulan),
            'penilaians as total_approved' => fn ($q) => $q->where('status', 'approved')
                ->where('tahun', $tahun)
                ->where('bulan', $bulan),
            'penilaians as total_rejected' => fn ($q) => $q->where('status', 'rejected')
                ->where('tahun', $tahun)
                ->where('bulan', $bulan),
        ])
        ->withAvg([
            'penilaians as rata_rata' => fn ($q) => $q->where('status', 'approved')
                ->where('tahun', $tahun)
                ->where('bulan', $bulan)
        ], 'nilai');

        // Tambahkan search jika ada
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_desa', 'like', "%{$search}%")
                  ->orWhere('kode_desa', 'like', "%{$search}%");
            });
        }

        // Order by nama desa
        $query->orderBy('nama_desa', 'asc');

        // Pagination dengan 10 item per halaman
        $desas = $query->paginate(10)->withQueryString();

        // Query terpisah untuk total keseluruhan (tanpa pagination)
        $totalQuery = Desa::withCount([
            'penilaians as total_pending' => fn ($q) => $q->where('status', 'pending')
                ->where('tahun', $tahun)
                ->where('bulan', $bulan),
            'penilaians as total_approved' => fn ($q) => $q->where('status', 'approved')
                ->where('tahun', $tahun)
                ->where('bulan', $bulan),
            'penilaians as total_rejected' => fn ($q) => $q->where('status', 'rejected')
                ->where('tahun', $tahun)
                ->where('bulan', $bulan),
        ]);

        if ($search) {
            $totalQuery->where(function($q) use ($search) {
                $q->where('nama_desa', 'like', "%{$search}%")
                  ->orWhere('kode_desa', 'like', "%{$search}%");
            });
        }

        $allDesas = $totalQuery->get();

        // Total keseluruhan untuk chart
        $totalApproved = $allDesas->sum('total_approved');
        $totalPending = $allDesas->sum('total_pending');
        $totalRejected = $allDesas->sum('total_rejected');

        return view('pages.admin.laporan', compact(
            'desas', 
            'tahun', 
            'bulan', 
            'totalApproved', 
            'totalPending', 
            'totalRejected',
            'search'
        ));
    }

    /**
     * 📋 Level 2: Detail per desa
     */
    public function showDesa(Desa $desa, Request $request)
    {
        $tahun = $request->get('tahun', now()->year);
        $bulan = $request->get('bulan', now()->format('F'));

        $klasters = Klaster::with(['indikators.penilaians' => function ($q) use ($desa, $tahun, $bulan) {
            $q->where('desa_id', $desa->id)
              ->where('tahun', $tahun)
              ->where('bulan', $bulan);
        }])->get();

        $klasters = $klasters->map(function ($klaster) {
            $penilaian = $klaster->indikators->flatMap->penilaians;
            $approved = $penilaian->where('status', 'approved');
            $rejected = $penilaian->where('status', 'rejected');
            $pending  = $penilaian->where('status', 'pending');

            $avg = $approved->count() > 0 ? round($approved->avg('nilai'), 2) : 0;
            $klaster->approved = $approved->count();
            $klaster->pending  = $pending->count();
            $klaster->rejected = $rejected->count();
            $klaster->rata_rata = $avg;
            return $klaster;
        });

        return view('pages.admin.laporan-detail', compact('desa', 'klasters', 'tahun', 'bulan'));
    }

    /**
     * 📤 Export Excel - All Desa (Approved Only)
     */
    public function exportExcel(Request $request)
    {
        $tahun = $request->get('tahun', now()->year);
        $bulan = $request->get('bulan', now()->format('F'));
        $desaId = $request->get('desa_id');

        $fileName = $desaId
            ? "Laporan_Desa_{$desaId}_{$bulan}_{$tahun}.xlsx"
            : "Laporan_Penilaian_Semua_Desa_{$bulan}_{$tahun}.xlsx";

        if ($desaId) {
            return Excel::download(new LaporanDesaExport($desaId, $tahun, $bulan), $fileName);
        }

        return Excel::download(new LaporanExport($tahun, $bulan), $fileName);
    }

    /**
     * 📄 Export PDF
     */
    public function exportPdf(Request $request)
    {
        $tahun = $request->get('tahun', now()->year);
        $bulan = $request->get('bulan', now()->format('F'));
        $desaId = $request->get('desa_id');

        if ($desaId) {
            // Export PDF untuk 1 desa
            $desa = Desa::findOrFail($desaId);

            $klasters = Klaster::with(['indikators.penilaians' => function ($q) use ($desa, $tahun, $bulan) {
                $q->where('desa_id', $desa->id)
                  ->where('tahun', $tahun)
                  ->where('bulan', $bulan)
                  ->where('status', 'approved');
            }])->get();

            $klasters = $klasters->map(function ($klaster) {
                $penilaian = $klaster->indikators->flatMap->penilaians;
                $approved = $penilaian->where('status', 'approved');

                $avg = $approved->count() > 0 ? round($approved->avg('nilai'), 2) : 0;
                $klaster->approved = $approved->count();
                $klaster->rata_rata = $avg;
                return $klaster;
            });

            $pdf = Pdf::loadView('exports.laporan-desa-pdf', compact('desa', 'klasters', 'tahun', 'bulan'))
                      ->setPaper('a4', 'portrait');

            return $pdf->download("Laporan_{$desa->nama_desa}_{$bulan}_{$tahun}.pdf");
        }

        // Export PDF untuk semua desa
        $penilaians = Penilaian::with(['desa', 'klaster', 'indikator'])
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->where('status', 'approved')
            ->orderBy('desa_id')
            ->orderBy('klaster_id')
            ->get();

        $pdf = Pdf::loadView('exports.laporan-pdf', compact('penilaians', 'tahun', $bulan))
                  ->setPaper('a4', 'landscape');

        return $pdf->download("Laporan_Penilaian_Semua_Desa_{$bulan}_{$tahun}.pdf");
    }
}
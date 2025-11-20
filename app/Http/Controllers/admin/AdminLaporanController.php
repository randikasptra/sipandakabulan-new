<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Klaster;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class AdminLaporanController extends Controller
{
    /**
     * 📊 Level 1: Rekap semua desa
     */
    public function index(Request $request)
    {
        $tahun = $request->get('tahun', now()->year);
        $bulan = $request->get('bulan', now()->format('F'));

        $desas = \App\Models\Desa::withCount([
            'penilaians as total_pending' => fn ($q) => $q->where('status', 'pending')->where('tahun', $tahun)->where('bulan', $bulan),
            'penilaians as total_approved' => fn ($q) => $q->where('status', 'approved')->where('tahun', $tahun)->where('bulan', $bulan),
            'penilaians as total_rejected' => fn ($q) => $q->where('status', 'rejected')->where('tahun', $tahun)->where('bulan', $bulan),
        ])
        ->withAvg(['penilaians as rata_rata' => fn ($q) => $q->where('tahun', $tahun)->where('bulan', $bulan)], 'nilai')
        ->get();

        // Total keseluruhan untuk chart doughnut
        $totalApproved = $desas->sum('total_approved');
        $totalPending = $desas->sum('total_pending');
        $totalRejected = $desas->sum('total_rejected');

        return view('pages.admin.laporan', compact('desas', 'tahun', 'bulan', 'totalApproved', 'totalPending', 'totalRejected'));
    }


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
     * 📤 Tahap 3: Export Excel (simulasi dulu)
     */
    public function exportExcel(Request $request)
    {
        $tahun = $request->get('tahun', now()->year);
        $bulan = $request->get('bulan', now()->format('F'));

        $fileName = "Laporan_Penilaian_{$bulan}_{$tahun}.xlsx";
        return Excel::download(new LaporanExport($tahun, $bulan), $fileName);
    }

    public function exportPdf(Request $request)
    {
        $tahun = $request->get('tahun', now()->year);
        $bulan = $request->get('bulan', now()->format('F'));

        $penilaians = \App\Models\Penilaian::with(['desa', 'klaster', 'indikator'])
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->where('status', 'approved')
            ->get();

        $pdf = Pdf::loadView('exports.laporan-pdf', compact('penilaians', 'tahun', 'bulan'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download("Laporan_Penilaian_{$bulan}_{$tahun}.pdf");
    }
}

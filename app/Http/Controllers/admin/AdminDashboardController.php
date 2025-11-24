<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\User;
use App\Models\Penilaian;
use App\Models\Klaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        // ===============================
        // FILTER (Default tahun & bulan sekarang)
        // ===============================
        $tahun = $request->get('tahun', now()->year);
        $bulan = $request->get('bulan', now()->format('F'));

        $monthsOrder = [
            'January','February','March','April','May','June',
            'July','August','September','October','November','December'
        ];

        // ===============================
        // 1. STATISTIK CARD
        // ===============================
        $totalDesa = Desa::count();
        $totalUserDesa = User::where('role', 'desa')->count();
        $totalPenilaian = Penilaian::count();

        // ===============================
        // 2. DOUGHNUT → STATUS BULAN INI
        // ===============================
        $totalApprovedThisMonth = Penilaian::where('status', 'approved')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->count();

        $totalPendingThisMonth = Penilaian::where('status', 'pending')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->count();

        $totalRejectedThisMonth = Penilaian::where('status', 'rejected')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->count();

        // ===============================
        // 3. LINE CHART → TREND 1 TAHUN
        // ===============================
        $trendYear = [];

        foreach ($monthsOrder as $m) {
            $trendYear[] = Penilaian::where('tahun', $tahun)
                ->where('bulan', $m)
                ->count();
        }

        // ===============================
        // 4. BAR CHART → RATA-RATA NILAI PER KLASTER
        // ===============================
        $klasters = Klaster::with(['penilaians' => function ($q) use ($tahun) {
            $q->where('tahun', $tahun)
              ->where('status', 'approved');
        }])->get();

        $klasterLabels = $klasters->pluck('title');

        $klasterData = $klasters->map(function ($k) {
            return round($k->penilaians->avg('nilai') ?? 0, 2);
        });

        // ===============================
        // 5. TOP DESA TERTINGGI
        // ===============================
        $topDesa = Desa::with(['penilaians' => fn ($q) => $q->where('status', 'approved')])
            ->get()
            ->map(function ($d) {
                $d->rata = round($d->penilaians->avg('nilai') ?? 0, 2);
                return $d;
            })
            ->sortByDesc('rata')
            ->take(5);

        // ===============================
        // 6. DESA PENDING TERBANYAK
        // ===============================
        $pendingDesa = Desa::withCount([
            'penilaians as total_pending' => fn ($q) => $q->where('status', 'pending')
        ])
        ->orderByDesc('total_pending')
        ->take(5)
        ->get();

        // ===============================
        // 7. AKTIVITAS TERBARU
        // ===============================
        $aktivitas = Penilaian::with(['desa','klaster','indikator'])
            ->latest()
            ->take(7)
            ->get();

        return view('pages.admin.dashboard', compact(
            'tahun',
            'bulan',
            'monthsOrder',
            'totalDesa',
            'totalUserDesa',
            'totalPenilaian',
            'totalApprovedThisMonth',
            'totalPendingThisMonth',
            'totalRejectedThisMonth',
            'trendYear',
            'klasterLabels',
            'klasterData',
            'topDesa',
            'pendingDesa',
            'aktivitas'
        ));
    }

}

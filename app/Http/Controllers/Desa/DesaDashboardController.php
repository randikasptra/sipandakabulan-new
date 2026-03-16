<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Klaster;
use App\Models\Penilaian;

class DesaDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $desa = $user->desa ?? null;
        $userId = $user->id;

        // Ambil semua klaster beserta indikator
        $klasters = Klaster::with('indikators')->get();

        // ==== Loop setiap klaster untuk hitung progres baru ====
        foreach ($klasters as $klaster) {

            $totalIndikator = $klaster->indikators->count();

            // Ambil penilaian user berdasarkan klaster
            $penilaians = Penilaian::where('user_id', $userId)
                ->where('klaster_id', $klaster->id)
                ->get();

            $penilaianCount = $penilaians->count();
            $totalNilai = $penilaians->sum('nilai');

            // Hitung nilai maksimal (fallback jika kosong)
            $nilaiMaksimal = $klaster->nilai_maksimal ?? ($totalIndikator * 100);

            // Hitung progres %
            $progress = $nilaiMaksimal > 0
                ? round(($totalNilai / $nilaiMaksimal) * 100, 2)
                : 0;

            // Tentukan status klaster
            if ($penilaians->count() === 0) {
                $status = '-';
            } elseif ($penilaians->where('status', 'rejected')->count() > 0) {
                $status = 'rejected';
            } elseif ($penilaians->every(fn ($p) => $p->status === 'approved')) {
                $status = 'approved';
            } elseif ($penilaians->every(fn ($p) => $p->status === 'pending')) {
                $status = 'pending';
            } else {
                $status = 'in_progress';
            }

            // Masukkan atribut dinamis ke klaster
            $klaster->nilai_em = $totalNilai;
            $klaster->nilai_maksimal = $nilaiMaksimal;
            $klaster->progres = $progress;
            $klaster->status = $status;
        }

        // ==== Hitung total dashboard progress ====
        $totalEm = $klasters->sum('nilai_em');
        $totalMax = $klasters->sum('nilai_maksimal');

        $totalProgress = $totalMax > 0
            ? ($totalEm / $totalMax) * 100
            : 0;

        return view('pages.desa.dashboard', compact(
            'klasters',
            'desa',
            'totalEm',
            'totalMax',
            'totalProgress'
        ));
    }
}

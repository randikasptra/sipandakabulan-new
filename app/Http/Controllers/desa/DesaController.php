<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\Klaster;
use App\Models\IndikatorKlaster;
use App\Models\Penilaian;
use Illuminate\Support\Facades\Auth;

class DesaController extends Controller
{
    /**
     * 📊 Dashboard Desa – Menampilkan semua klaster beserta progres, nilai EM, dan status penilaian.
     */
    public function index()
    {
        $userId = Auth::id();

        // Ambil semua klaster beserta indikatornya
        $klasters = Klaster::with('indikators')->get();

        foreach ($klasters as $klaster) {
            $totalIndikator = $klaster->indikators->count();

            // Ambil semua penilaian milik user & klaster ini
            $penilaians = Penilaian::where('user_id', $userId)
                ->where('klaster_id', $klaster->id)
                ->get();

            $penilaianCount = $penilaians->count();
            $totalNilai = $penilaians->sum('nilai');

            // Ambil nilai maksimal dari klaster (default manual jika kosong)
            $nilaiMaksimal = $klaster->nilai_maksimal ?? ($totalIndikator * 100);

            // Hitung progres (%)
            $progress = $nilaiMaksimal > 0
                ? round(($totalNilai / $nilaiMaksimal) * 100, 2)
                : 0;

            // 💡 Tentukan status gabungan klaster
            if ($penilaianCount === 0) {
                $status = '-';
            } elseif ($penilaians->where('status', 'rejected')->count() > 0) {
                $status = 'rejected';
            } elseif ($penilaians->every(fn ($p) => $p->status === 'approved')) {
                $status = 'approved';
            } elseif ($penilaians->every(fn ($p) => $p->status === 'pending')) {
                $status = 'pending';
            } else {
                $status = 'in_progress'; // ada campuran antara pending & draft
            }

            // Tambahkan properti dinamis untuk view
            $klaster->nilai_em = $totalNilai;
            $klaster->nilai_maksimal = $nilaiMaksimal;
            $klaster->progres = $progress;
            $klaster->status = $status;
        }

        return view('pages.desa.dashboard', compact('klasters'));
    }

    /**
     * 🧩 Menampilkan detail satu klaster berdasarkan slug (beserta penilaian yang sudah pernah disimpan user).
     */
    public function showKlaster($slug)
    {
        $userId = Auth::id();

        $klaster = Klaster::where('slug', $slug)
            ->with(['indikators.opsiNilai', 'indikators.kategoriUploads'])
            ->firstOrFail();

        // Ambil penilaian user sebelumnya (untuk preload data di form)
        $penilaians = Penilaian::where('user_id', $userId)
            ->where('klaster_id', $klaster->id)
            ->get()
            ->keyBy('indikator_id');

        return view('pages.desa.klaster-detail', compact('klaster', 'penilaians'));
    }

    /**
     * 📄 Menampilkan detail indikator tunggal (opsi nilai + kategori upload + nilai lama).
     */
    public function showIndikator($klasterSlug, $indikatorSlug)
    {
        $userId = Auth::id();

        $indikator = IndikatorKlaster::where('slug', $indikatorSlug)
            ->with(['opsiNilai', 'kategoriUploads'])
            ->firstOrFail();

        // Ambil nilai user untuk indikator ini (jika sudah pernah isi)
        $penilaian = Penilaian::where('indikator_id', $indikator->id)
            ->where('user_id', $userId)
            ->first();

        return view('pages.desa.indikator-detail', compact('indikator', 'penilaian'));
    }
}

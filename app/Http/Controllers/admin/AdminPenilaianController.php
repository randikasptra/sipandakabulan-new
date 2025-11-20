<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Klaster;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class AdminPenilaianController extends Controller
{
    // 🏘️ Level 1: List semua desa
    public function index(Request $request)
    {
        $tahun = $request->get('tahun', now()->year);
        $bulan = $request->get('bulan', now()->format('F')); // "November"
        $status = $request->get('status');

        $desas = Desa::withCount([
            'penilaians as total_pending' => fn ($q) =>
                $q->where('status', 'pending')->where('tahun', $tahun)->where('bulan', $bulan),
            'penilaians as total_approved' => fn ($q) =>
                $q->where('status', 'approved')->where('tahun', $tahun)->where('bulan', $bulan),
            'penilaians as total_rejected' => fn ($q) =>
                $q->where('status', 'rejected')->where('tahun', $tahun)->where('bulan', $bulan),
        ])->get();

        $totalApproved = $desas->sum('total_approved');
        $totalPending  = $desas->sum('total_pending');
        $totalRejected = $desas->sum('total_rejected');

        return view('pages.admin.penilaian', compact(
            'desas',
            'tahun',
            'bulan',
            'status',
            'totalApproved',
            'totalPending',
            'totalRejected'
        ));
    }

    // 📊 Level 2: List klaster per desa
    public function showDesa(Desa $desa, Request $request)
    {
        $tahun = $request->get('tahun', now()->year);
        $bulan = $request->get('bulan', now()->format('F')); // Konsisten dengan index()

        $klasters = Klaster::withCount([
            'indikators as total_indikator',
            'penilaians as total_pending' => fn ($q) =>
                $q->where('desa_id', $desa->id)
                  ->where('status', 'pending')
                  ->where('tahun', $tahun)
                  ->where('bulan', $bulan),
            'penilaians as total_approved' => fn ($q) =>
                $q->where('desa_id', $desa->id)
                  ->where('status', 'approved')
                  ->where('tahun', $tahun)
                  ->where('bulan', $bulan),
            'penilaians as total_rejected' => fn ($q) =>
                $q->where('desa_id', $desa->id)
                  ->where('status', 'rejected')
                  ->where('tahun', $tahun)
                  ->where('bulan', $bulan),
        ])->get();

        return view('pages.admin.penilaian-klaster', compact('desa', 'klasters', 'tahun', 'bulan'));
    }

    // 📋 Level 3: List indikator dalam klaster tertentu
    public function showKlaster(Desa $desa, Klaster $klaster)
    {
        $penilaians = Penilaian::with(['indikator', 'berkasUploads'])
            ->where('desa_id', $desa->id)
            ->where('klaster_id', $klaster->id)
            ->get();

        return view('pages.admin.penilaian-detail', compact('desa', 'klaster', 'penilaians'));
    }

    // ✅ Approve
    public function approve(Penilaian $penilaian)
    {
        $penilaian->update(['status' => 'approved']);
        return response()->json(['success' => true, 'message' => '✅ Penilaian disetujui.']);
    }

    // ❌ Reject
    public function reject(Penilaian $penilaian)
    {
        $penilaian->update(['status' => 'rejected']);
        return response()->json(['success' => true, 'message' => '❌ Penilaian ditolak.']);
    }
}

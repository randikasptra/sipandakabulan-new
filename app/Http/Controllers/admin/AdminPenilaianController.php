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
        // Ambil filter tahun & bulan dari request (default: bulan dan tahun sekarang)
        $tahun = $request->get('tahun', now()->year);
        $bulan = $request->get('bulan', now()->format('F'));
        $status = $request->get('status');

        // Ambil semua desa dengan count status penilaiannya
        $desas = Desa::withCount([
            'penilaians as total_pending' => fn ($q) =>
                $q->where('status', 'pending')->where('tahun', $tahun)->where('bulan', $bulan),
            'penilaians as total_approved' => fn ($q) =>
                $q->where('status', 'approved')->where('tahun', $tahun)->where('bulan', $bulan),
            'penilaians as total_rejected' => fn ($q) =>
                $q->where('status', 'rejected')->where('tahun', $tahun)->where('bulan', $bulan),
        ])->get();

        // Hitung total keseluruhan untuk mini chart
        $totalApproved = $desas->sum('total_approved');
        $totalPending  = $desas->sum('total_pending');
        $totalRejected = $desas->sum('total_rejected');

        // Kirim ke view
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
    public function showDesa(Desa $desa)
    {
        $klasters = Klaster::withCount([
            'indikators as total_indikator',
            'penilaians as total_pending' => fn ($q) => $q->where('desa_id', $desa->id)->where('status', 'pending'),
            'penilaians as total_approved' => fn ($q) => $q->where('desa_id', $desa->id)->where('status', 'approved'),
            'penilaians as total_rejected' => fn ($q) => $q->where('desa_id', $desa->id)->where('status', 'rejected'),
        ])->get();

        return view('pages.admin.penilaian-klaster', compact('desa', 'klasters'));
    }

    // 📋 Level 3: List indikator dalam klaster tertentu
    public function showKlaster(Desa $desa, Klaster $klaster, Request $request)
    {
        $tahun = $request->get('tahun', now()->year);
        $bulan = $request->get('bulan', now()->format('F'));
        $status = $request->get('status');

        $query = Penilaian::with(['indikator', 'berkasUploads'])
            ->where('desa_id', $desa->id)
            ->where('klaster_id', $klaster->id)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan);

        if ($status) {
            $query->where('status', $status);
        }

        $penilaians = $query->get();

        return view('pages.admin.penilaian-detail', compact('desa', 'klaster', 'penilaians', 'tahun', 'bulan', 'status'));
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

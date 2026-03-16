<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Klaster;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class AdminPenilaianController extends Controller
{
    // 🏘️ Level 1: List semua desa dengan penilaian mereka
    public function index(Request $request)
    {
        $tahun  = $request->get('tahun', now()->year);
        $bulan  = $request->get('bulan', now()->format('F'));
        $status = $request->get('status');
        $search = $request->get('search');

        // Query untuk tabel desa (dengan filter status jika ada)
        $desas = Desa::query()
            ->when($search, function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('nama_desa', 'like', "%{$search}%")
                        ->orWhere('kode_desa', 'like', "%{$search}%");
                });
            })
            ->withCount([
                'penilaians as total_pending' => fn($q) =>
                $q->where('status', 'pending')
                    ->where('tahun', $tahun)
                    ->where('bulan', $bulan),

                'penilaians as total_approved' => fn($q) =>
                $q->where('status', 'approved')
                    ->where('tahun', $tahun)
                    ->where('bulan', $bulan),

                'penilaians as total_rejected' => fn($q) =>
                $q->where('status', 'rejected')
                    ->where('tahun', $tahun)
                    ->where('bulan', $bulan),
            ])
            ->when($status, function ($q) use ($status, $tahun, $bulan) {
                $q->whereHas('penilaians', function ($qq) use ($status, $tahun, $bulan) {
                    $qq->where('status', $status)
                        ->where('tahun', $tahun)
                        ->where('bulan', $bulan);
                });
            })
            ->orderBy('nama_desa')
            ->paginate(20)
            ->withQueryString();

        // ✅ Query terpisah untuk chart - TANPA filter status
        $allDesas = Desa::withCount([
            'penilaians as total_pending' => fn($q) =>
            $q->where('status', 'pending')
                ->where('tahun', $tahun)
                ->where('bulan', $bulan),

            'penilaians as total_approved' => fn($q) =>
            $q->where('status', 'approved')
                ->where('tahun', $tahun)
                ->where('bulan', $bulan),

            'penilaians as total_rejected' => fn($q) =>
            $q->where('status', 'rejected')
                ->where('tahun', $tahun)
                ->where('bulan', $bulan),
        ])->get();

        $totalApproved = $allDesas->sum('total_approved');
        $totalPending  = $allDesas->sum('total_pending');
        $totalRejected = $allDesas->sum('total_rejected');

        return view('pages.admin.penilaian', compact(
            'desas',
            'tahun',
            'bulan',
            'status',
            'search',
            'totalApproved',
            'totalPending',
            'totalRejected'
        ));
    }

    // 📊 Level 2: List klaster per desa
    public function showDesa(Desa $desa, Request $request)
    {
        $tahun = $request->get('tahun', now()->year);
        $bulan = $request->get('bulan', now()->format('F'));

        $klasters = Klaster::withCount([
            'indikators as total_indikator',
            'penilaians as total_pending' => fn($q) =>
            $q->where('desa_id', $desa->id)
                ->where('status', 'pending')
                ->where('tahun', $tahun)
                ->where('bulan', $bulan),
            'penilaians as total_approved' => fn($q) =>
            $q->where('desa_id', $desa->id)
                ->where('status', 'approved')
                ->where('tahun', $tahun)
                ->where('bulan', $bulan),
            'penilaians as total_rejected' => fn($q) =>
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
        // ✅ Load penilaian dengan eager loading kategori upload
        $penilaians = Penilaian::with([
            'indikator.opsiNilai',
            'berkasUploads' => function($query) {
                $query->with('kategoriUpload')->orderBy('kategori_upload_id');
            },
            'catatan.user'
        ])
            ->where('desa_id', $desa->id)
            ->where('klaster_id', $klaster->id)
            ->get();

        return view('pages.admin.penilaian-detail', compact('desa', 'klaster', 'penilaians'));
    }

    // ✅ Approve penilaian (ID dari request body)
    public function approve(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:penilaians,id'
        ]);
        
        $penilaian = Penilaian::findOrFail($request->id);
        
        $penilaian->update([
            'status' => 'approved',
            'rejection_reason' => null,
            'verified_at' => now(),
            'verified_by' => auth()->id()
        ]);

        return response()->json([
            'success' => true,
            'message' => '✅ Penilaian berhasil disetujui.'
        ]);
    }

    // ❌ Reject penilaian dengan alasan (ID dari request body)
    public function reject(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:penilaians,id',
            'reason' => 'required|string|min:5|max:500'
        ], [
            'reason.required' => 'Alasan penolakan wajib diisi',
            'reason.min' => 'Alasan penolakan minimal 5 karakter',
            'reason.max' => 'Alasan penolakan maksimal 500 karakter'
        ]);
        
        $penilaian = Penilaian::findOrFail($request->id);

        $penilaian->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason,
            'verified_at' => now(),
            'verified_by' => auth()->id()
        ]);

        return response()->json([
            'success' => true,
            'message' => '❌ Penilaian berhasil ditolak beserta alasannya.'
        ]);
    }
}
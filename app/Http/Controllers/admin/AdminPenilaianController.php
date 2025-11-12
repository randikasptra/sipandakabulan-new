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
    public function index()
    {
        $desas = Desa::withCount([
            'penilaians as total_pending' => fn ($q) => $q->where('status', 'pending'),
            'penilaians as total_approved' => fn ($q) => $q->where('status', 'approved'),
            'penilaians as total_rejected' => fn ($q) => $q->where('status', 'rejected'),
        ])->get();

        return view('pages.admin.penilaian', compact('desas'));
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

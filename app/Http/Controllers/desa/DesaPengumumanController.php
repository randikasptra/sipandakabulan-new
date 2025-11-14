<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class DesaPengumumanController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $desaId = $user->desa_id;

        // ✅ FIX: Gunakan custom scope
        $query = Pengumuman::forDesa($desaId)->latest();

        // Filter by search (judul)
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        // Filter by bulan & tahun
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun)
                  ->whereMonth('created_at', $request->bulan);
        }

        $pengumumans = $query->paginate(12);

        // Data untuk filter dropdown
        $bulanList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $tahunList = Pengumuman::selectRaw('YEAR(created_at) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('pages.desa.pengumuman', compact('pengumumans', 'bulanList', 'tahunList'));
    }

    // Detail pengumuman (untuk AJAX modal)
    public function show(Pengumuman $pengumuman)
    {
        $user = auth()->user();

        // Validasi: pastikan pengumuman ini untuk desa user
        if (!in_array($user->desa_id, $pengumuman->desa_ids ?? [])) {
            abort(403, 'Pengumuman ini tidak ditujukan untuk desa Anda.');
        }

        return response()->json([
            'success' => true,
            'data' => [
                'judul' => $pengumuman->judul,
                'isi' => $pengumuman->isi,
                'file' => $pengumuman->file,
                'created_at' => $pengumuman->created_at->format('d F Y, H:i'),
                'file_url' => $pengumuman->file
                    ? env('SUPABASE_URL') . '/storage/v1/object/public/' . env('SUPABASE_STORAGE_BUCKET') . '/' . $pengumuman->file
                    : null,
                'file_name' => $pengumuman->file ? basename($pengumuman->file) : null,
            ]
        ]);
    }
}

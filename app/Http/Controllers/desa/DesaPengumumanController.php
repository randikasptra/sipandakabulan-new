<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesaPengumumanController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $desaId = $user->desa_id;

        // Gunakan custom scope
        $query = Pengumuman::forDesa($desaId)->latest();

        // Filter by search (judul dan isi)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('isi', 'like', '%' . $search . '%');
            });
        }

        // Filter by bulan & tahun
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun)
                  ->whereMonth('created_at', $request->bulan);
        } elseif ($request->filled('tahun')) {
            // Filter hanya tahun jika bulan tidak diisi
            $query->whereYear('created_at', $request->tahun);
        }

        $pengumumans = $query->paginate(12);

        // Data untuk filter dropdown
        $bulanList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        // Ambil tahun dari pengumuman yang tersedia untuk desa ini
        $tahunList = Pengumuman::forDesa($desaId)
            ->selectRaw('YEAR(created_at) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('pages.desa.pengumuman', compact('pengumumans', 'bulanList', 'tahunList'));
    }

    // Detail pengumuman (untuk AJAX modal)
    public function show(Pengumuman $pengumuman)
    {
        try {
            $user = auth()->user();
            $desaId = $user->desa_id;

            // Cek apakah pengumuman ditujukan untuk desa user
            if (!$pengumuman->isForDesa($desaId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengumuman ini tidak ditujukan untuk desa Anda.'
                ], 403);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'judul' => $pengumuman->judul,
                    'isi' => $pengumuman->isi,
                    'created_at' => $pengumuman->created_at->format('d F Y, H:i'),
                    'file_url' => $pengumuman->file_url,
                    'file_name' => $pengumuman->file ? basename($pengumuman->file) : null,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memuat pengumuman.'
            ], 500);
        }
    }
}

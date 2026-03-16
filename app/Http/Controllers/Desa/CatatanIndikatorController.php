<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\CatatanIndikator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatatanIndikatorController extends Controller
{
    /**
     * 🔹 Ambil catatan per indikator (AJAX)
     */
    public function byIndikator($indikatorId)
    {
        $desaId = Auth::user()->desa_id;
        $tahun  = now()->year;

        $catatans = CatatanIndikator::where([
                'indikator_id' => $indikatorId,
                'desa_id'      => $desaId,
                'tahun'        => $tahun,
            ])
            ->with('user:id,name')
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $catatans
        ]);
    }

    /**
     * 🔹 Simpan catatan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'indikator_id' => 'required|exists:indikator_klaster,id',
            'catatan'      => 'required|string'
        ]);

        $catatan = CatatanIndikator::create([
            'desa_id'     => Auth::user()->desa_id,
            'indikator_id'=> $request->indikator_id,
            'user_id'     => Auth::id(),
            'tahun'       => now()->year,
            'catatan'     => $request->catatan,
        ]);

        $catatan->load('user:id,name');

        return response()->json([
            'success' => true,
            'data' => $catatan
        ]);
    }

    /**
     * 🔹 Update catatan
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string'
        ]);

        $catatan = CatatanIndikator::where('id', $id)
            ->where('user_id', Auth::id()) // hanya pembuat
            ->firstOrFail();

        $catatan->update([
            'catatan' => $request->catatan
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * 🔹 Hapus catatan
     */
    public function destroy($id)
    {
        $catatan = CatatanIndikator::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $catatan->delete();

        return response()->json([
            'success' => true
        ]);
    }
}

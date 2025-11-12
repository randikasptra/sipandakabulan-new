<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\Penilaian;
use App\Models\BerkasUpload;
use App\Models\KategoriUpload;
use App\Models\IndikatorKlaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PenilaianController extends Controller
{
    /**
     * Simpan atau update penilaian.
     */
    public function store(Request $request)
    {
        $desaId = Auth::user()->desa_id;
        $userId = Auth::id();

        if (!$desaId) {
            return back()->with('error', '❌ Akun belum terhubung ke desa.');
        }

        $savedCount = 0;

        // ==============================
        // 1️⃣ SIMPAN NILAI INDIKATOR
        // ==============================
        foreach ($request->all() as $key => $value) {
            if (!Str::startsWith($key, 'indikator_')) {
                continue;
            }

            $indikatorId = (int) Str::after($key, 'indikator_');
            $indikator = IndikatorKlaster::find($indikatorId);
            if (!$indikator) {
                continue;
            }

            $existing = Penilaian::where([
                'desa_id' => $desaId,
                'klaster_id' => $indikator->klaster_id,
                'indikator_id' => $indikatorId,
                'tahun' => now()->year,
            ])->first();

            if ($existing && $existing->status === 'approved') {
                continue;
            }

            Penilaian::updateOrCreate(
                [
                    'desa_id' => $desaId,
                    'klaster_id' => $indikator->klaster_id,
                    'indikator_id' => $indikatorId,
                    'tahun' => now()->year,
                ],
                [
                    'user_id' => $userId,
                    'nilai' => $value,
                    'bulan' => now()->format('F'),
                    'status' => 'pending',
                ]
            );


            $savedCount++;
        }

        // ==============================
        // 2️⃣ UPLOAD BERKAS KE SUPABASE
        // ==============================
        foreach ($request->files as $key => $file) {
            if (!Str::startsWith($key, 'file_') || $file === null) {
                continue;
            }

            $kategoriId = (int) Str::after($key, 'file_');
            $kategori = KategoriUpload::find($kategoriId);
            if (!$kategori) {
                continue;
            }

            $filename = time() . '_' . $file->getClientOriginalName();
            $indikator = IndikatorKlaster::find($kategori->indikator_id);
            $klaster = $indikator?->klaster;
            $klasterSlug = $klaster ? Str::slug($klaster->slug ?? $klaster->title, '-') : 'unknown';
            $path = "desa/{$klasterSlug}/{$filename}";

            // Upload ke Supabase
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('SUPABASE_SERVICE_ROLE_KEY'),
                'Content-Type' => $file->getClientMimeType(),
            ])->withBody(
                file_get_contents($file->getRealPath()),
                $file->getClientMimeType()
            )->put(
                env('SUPABASE_URL') . '/storage/v1/object/' . env('SUPABASE_STORAGE_BUCKET') . '/' . $path
            );

            if ($response->failed()) {
                Log::error('Gagal upload ke Supabase', [
                    'file' => $filename,
                    'error' => $response->body(),
                ]);
                continue;
            }

            // Simpan ke database
            $penilaianId = Penilaian::where([
                'desa_id' => $desaId,
                'indikator_id' => $kategori->indikator_id,
                'tahun' => now()->year,
            ])->value('id');

            if ($penilaianId) {
                BerkasUpload::updateOrCreate(
                    [
                        'penilaian_id' => $penilaianId,
                        'kategori_upload_id' => $kategori->id,
                    ],
                    [
                        'path_file' => $path,
                        'nilai' => 0,
                    ]
                );
            }
        }

        return back()->with('success', "✅ {$savedCount} penilaian berhasil disimpan!");
    }

    /**
     * Batalkan / hapus pengiriman penilaian sebelum disetujui.
     */
    public function cancelByKlaster($klasterId)
    {
        $user = Auth::user();

        // Ambil semua penilaian untuk klaster ini
        $penilaians = Penilaian::where('desa_id', $user->desa_id)
            ->where('klaster_id', $klasterId)
            ->where('tahun', now()->year)
            ->get();

        if ($penilaians->isEmpty()) {
            return back()->with('error', 'Tidak ada penilaian untuk klaster ini.');
        }

        // Cek kalau ada yang sudah disetujui (approved)
        if ($penilaians->contains(fn ($p) => $p->status === 'approved')) {
            return back()->with('error', 'Tidak bisa membatalkan karena ada penilaian yang sudah disetujui.');
        }

        try {
            foreach ($penilaians as $penilaian) {
                $berkasList = BerkasUpload::where('penilaian_id', $penilaian->id)->get();

                foreach ($berkasList as $berkas) {
                    try {
                        // Hapus file dari Supabase
                        $url = env('SUPABASE_URL') . '/storage/v1/object/' . env('SUPABASE_STORAGE_BUCKET') . '/' . $berkas->path_file;
                        Http::withHeaders([
                            'Authorization' => 'Bearer ' . env('SUPABASE_SERVICE_ROLE_KEY'),
                        ])->delete($url);

                        $berkas->delete();
                    } catch (\Exception $e) {
                        Log::error('Gagal hapus file Supabase', [
                            'path' => $berkas->path_file,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }

                // Hapus penilaian
                $penilaian->delete();
            }

            return back()->with('success', '🗑️ Semua penilaian dan berkas di klaster ini berhasil dibatalkan & dihapus.');
        } catch (\Throwable $th) {
            Log::error('Gagal membatalkan klaster', [
                'error' => $th->getMessage(),
                'klaster_id' => $klasterId,
            ]);
            return back()->with('error', 'Terjadi kesalahan saat membatalkan klaster.');
        }
    }

}

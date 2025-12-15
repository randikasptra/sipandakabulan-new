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
        $bulan = now()->format('F');
        $tahun = now()->year;

        if (!$desaId) {
            return back()->with('error', '❌ Akun belum terhubung ke desa.');
        }

        $savedCount = 0;

        // ==============================
        // 1️⃣ SIMPAN NILAI INDIKATOR (PER BULAN)
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

            // Cari existing penilaian PER BULAN
            $existing = Penilaian::where([
                'desa_id' => $desaId,
                'klaster_id' => $indikator->klaster_id,
                'indikator_id' => $indikatorId,
                'bulan' => $bulan,
                'tahun' => $tahun,
            ])->first();

            // Jika bulan ini sudah APPROVED → tidak boleh edit
            if ($existing && $existing->status === 'approved') {
                continue;
            }

            Penilaian::updateOrCreate(
                [
                    'desa_id' => $desaId,
                    'klaster_id' => $indikator->klaster_id,
                    'indikator_id' => $indikatorId,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                ],
                [
                    'user_id' => $userId,
                    'nilai' => $value,
                    'status' => 'pending',
                ]
            );

            $savedCount++;
        }

        // ==============================
        // 2️⃣ UPLOAD BERKAS PER BULAN KE SUPABASE
        // ==============================
        foreach ($request->files as $key => $files) {
            if (!Str::startsWith($key, 'file_')) {
                continue;
            }

            $kategoriId = (int) Str::after($key, 'file_');
            $kategori = KategoriUpload::find($kategoriId);
            if (!$kategori) {
                continue;
            }

            $indikator = IndikatorKlaster::find($kategori->indikator_id);
            $klaster = $indikator?->klaster;
            $klasterSlug = $klaster ? Str::slug($klaster->slug ?? $klaster->title, '-') : 'unknown';

            // Support multiple files per kategori
            $filesArray = is_array($files) ? $files : [$files];

            foreach ($filesArray as $file) {
                if (!$file || !$file->isValid()) {
                    continue;
                }

                $filename = time() . '_' . Str::random(8) . '_' . Str::slug($file->getClientOriginalName(), '_');
                $path = "desa/{$klasterSlug}/{$tahun}/{$bulan}/{$filename}";

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
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                ])->value('id');

                if ($penilaianId) {
                    BerkasUpload::create([
                        'penilaian_id' => $penilaianId,
                        'kategori_upload_id' => $kategori->id,
                        'path_file' => $path,
                        'nilai' => 0,
                    ]);
                }
            }
        }

        return back()->with('success', "✅ {$savedCount} penilaian bulan {$bulan} berhasil disimpan!");
    }

    /**
     * Tambah kategori upload custom
     */
    public function storeKategoriCustom(Request $request)
    {
        $request->validate([
            'indikator_id' => 'required|exists:indikator_klaster,id',
            'nama_kategori' => 'required|string|max:255',
        ]);

        $desaId = Auth::user()->desa_id;

        if (!$desaId) {
            return response()->json(['error' => 'Desa tidak ditemukan'], 403);
        }

        $kategori = KategoriUpload::create([
            'indikator_id' => $request->indikator_id,
            'nama_kategori' => $request->nama_kategori,
            'is_custom' => true,
            'desa_id' => $desaId,
        ]);

        return response()->json([
            'success' => true,
            'data' => $kategori,
        ]);
    }

    /**
     * Hapus kategori custom
     */
    public function deleteKategoriCustom($kategoriId)
    {
        $desaId = Auth::user()->desa_id;

        $kategori = KategoriUpload::where('id', $kategoriId)
            ->where('is_custom', true)
            ->where('desa_id', $desaId)
            ->first();

        if (!$kategori) {
            return response()->json(['error' => 'Kategori tidak ditemukan'], 404);
        }

        // Hapus semua berkas terkait
        $berkasList = BerkasUpload::where('kategori_upload_id', $kategoriId)->get();

        foreach ($berkasList as $berkas) {
            try {
                $url = env('SUPABASE_URL') . '/storage/v1/object/' .
                    env('SUPABASE_STORAGE_BUCKET') . '/' . $berkas->path_file;

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

        $kategori->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Batalkan penilaian 1 klaster (bulan berjalan saja)
     */
    public function cancelByKlaster($klasterId)
    {
        $user = Auth::user();
        $bulan = now()->format('F');
        $tahun = now()->year;

        $penilaians = Penilaian::where('desa_id', $user->desa_id)
            ->where('klaster_id', $klasterId)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get();

        if ($penilaians->isEmpty()) {
            return back()->with('error', 'Tidak ada penilaian bulan ini untuk klaster ini.');
        }

        if ($penilaians->contains(fn($p) => $p->status === 'approved')) {
            return back()->with('error', 'Tidak bisa membatalkan karena penilaian bulan ini sudah disetujui.');
        }

        try {
            foreach ($penilaians as $penilaian) {
                $berkasList = BerkasUpload::where('penilaian_id', $penilaian->id)->get();

                foreach ($berkasList as $berkas) {
                    try {
                        $url = env('SUPABASE_URL') . '/storage/v1/object/' .
                            env('SUPABASE_STORAGE_BUCKET') . '/' . $berkas->path_file;

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

                $penilaian->delete();
            }

            return back()->with('success', '🗑️ Penilaian bulan ini untuk klaster ini berhasil dibatalkan.');
        } catch (\Throwable $th) {
            Log::error('Gagal membatalkan klaster', [
                'error' => $th->getMessage(),
                'klaster_id' => $klasterId,
            ]);

            return back()->with('error', 'Terjadi kesalahan saat membatalkan.');
        }
    }
    /**
     * Get kategoris by indikator (untuk AJAX)
     */
    public function getKategorisByIndikator($indikatorId)
    {
        $desaId = Auth::user()->desa_id;

        $kategoris = KategoriUpload::where('indikator_id', $indikatorId)
            ->where(function ($q) use ($desaId) {
                $q->where('is_custom', false)
                    ->orWhere(function ($q2) use ($desaId) {
                        $q2->where('is_custom', true)
                            ->where('desa_id', $desaId);
                    });
            })
            ->get();

        return response()->json([
            'success' => true,
            'data' => $kategoris
        ]);
    }
}

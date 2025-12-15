<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\Penilaian;
use App\Models\BerkasUpload;
use App\Models\KategoriUpload;
use App\Models\IndikatorKlaster;
use App\Models\CatatanIndikator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PenilaianController extends Controller
{
    /**
     * Simpan atau update penilaian.
     */
    public function store(Request $request)
    {
        $desaId = Auth::user()->desa_id;
        $userId = Auth::id();
        $tahun = now()->year;

        if (!$desaId) {
            return back()->with('error', '❌ Akun belum terhubung ke desa.');
        }

        DB::beginTransaction();

        try {
            $savedCount = 0;

            // ==============================
            // 1️⃣ PROSES CUSTOM KATEGORI BARU DULU
            // ==============================
            $customKategoriMapping = [];

            foreach ($request->all() as $key => $value) {
                if (Str::startsWith($key, 'custom_kategori_nama_')) {
                    preg_match('/custom_kategori_nama_(\d+)_(\d+)/', $key, $matches);

                    if (count($matches) === 3) {
                        $indikatorId = (int) $matches[1];
                        $tempIndex = (int) $matches[2];
                        $namaKategori = $value;

                        if (empty($namaKategori)) {
                            continue;
                        }

                        $kategori = KategoriUpload::create([
                            'indikator_id' => $indikatorId,
                            'nama_kategori' => $namaKategori,
                            'is_custom' => true,
                            'desa_id' => $desaId,
                        ]);

                        $customKategoriMapping["{$indikatorId}_{$tempIndex}"] = $kategori->id;

                        Log::info("✅ Custom kategori created", [
                            'indikator_id' => $indikatorId,
                            'temp_index' => $tempIndex,
                            'kategori_id' => $kategori->id,
                            'nama' => $namaKategori
                        ]);
                    }
                }
            }

            // ==============================
            // 2️⃣ SIMPAN NILAI INDIKATOR (PER TAHUN)
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

                // Cari existing penilaian PER TAHUN
                $existing = Penilaian::where([
                    'desa_id' => $desaId,
                    'klaster_id' => $indikator->klaster_id,
                    'indikator_id' => $indikatorId,
                    'tahun' => $tahun,
                ])->first();

                // Jika tahun ini sudah APPROVED → tidak boleh edit
                if ($existing && $existing->status === 'approved') {
                    continue;
                }

                Penilaian::updateOrCreate(
                    [
                        'desa_id' => $desaId,
                        'klaster_id' => $indikator->klaster_id,
                        'indikator_id' => $indikatorId,
                        'tahun' => $tahun,
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
            // 2️⃣b SIMPAN CATATAN INDIKATOR (PER TAHUN)
            // ==============================
            foreach ($request->all() as $key => $value) {

                if (!Str::startsWith($key, 'catatan_')) {
                    continue;
                }

                $indikatorId = (int) Str::after($key, 'catatan_');

                if (trim($value) === '') {
                    continue;
                }

                // ⛔ WAJIB: penilaian HARUS ADA
                $penilaian = Penilaian::where([
                    'desa_id' => $desaId,
                    'indikator_id' => $indikatorId,
                    'tahun' => $tahun,
                ])->first();

                // Jika belum ada penilaian → jangan simpan catatan
                if (!$penilaian) {
                    Log::warning("⚠️ Catatan dilewati karena penilaian belum ada", [
                        'indikator_id' => $indikatorId
                    ]);
                    continue;
                }

                // Jika sudah approved → terkunci
                if ($penilaian->status === 'approved') {
                    continue;
                }

                CatatanIndikator::updateOrCreate(
                    [
                        'desa_id'      => $desaId,
                        'indikator_id' => $indikatorId,
                        'tahun'        => $tahun,
                    ],
                    [
                        'user_id' => $userId,
                        'catatan' => $value,
                    ]
                );

                Log::info("✅ Catatan saved", [
                    'indikator_id' => $indikatorId,
                    'penilaian_id' => $penilaian->id
                ]);
            }


            // ==============================
            // 3️⃣ UPLOAD BERKAS PER TAHUN KE SUPABASE
            // ==============================
            foreach ($request->allFiles() as $key => $uploadedFiles) {
                if (!Str::startsWith($key, 'file_') && !Str::startsWith($key, 'custom_kategori_file_')) {
                    continue;
                }

                $kategoriId = null;

                if (Str::startsWith($key, 'file_')) {
                    $kategoriId = (int) Str::after($key, 'file_');
                } elseif (Str::startsWith($key, 'custom_kategori_file_')) {
                    preg_match('/custom_kategori_file_(\d+)_(\d+)/', $key, $matches);

                    if (count($matches) === 3) {
                        $indikatorId = (int) $matches[1];
                        $tempIndex = (int) $matches[2];
                        $mapKey = "{$indikatorId}_{$tempIndex}";

                        if (isset($customKategoriMapping[$mapKey])) {
                            $kategoriId = $customKategoriMapping[$mapKey];

                            Log::info("📎 Mapping custom file", [
                                'key' => $key,
                                'map_key' => $mapKey,
                                'kategori_id' => $kategoriId
                            ]);
                        }
                    }
                }

                if (!$kategoriId) {
                    Log::warning("⚠️ Kategori tidak ditemukan untuk key: {$key}");
                    continue;
                }

                $kategori = KategoriUpload::find($kategoriId);
                if (!$kategori) {
                    Log::warning("⚠️ Kategori ID {$kategoriId} tidak ada di database");
                    continue;
                }

                $indikator = IndikatorKlaster::find($kategori->indikator_id);
                $klaster = $indikator?->klaster;
                $klasterSlug = $klaster ? Str::slug($klaster->slug ?? $klaster->title, '-') : 'unknown';

                $filesArray = is_array($uploadedFiles) ? $uploadedFiles : [$uploadedFiles];

                Log::info("📤 Processing files for kategori {$kategoriId}", [
                    'key' => $key,
                    'total_files' => count($filesArray)
                ]);

                foreach ($filesArray as $fileIndex => $file) {
                    if (!$file || !$file->isValid()) {
                        Log::warning("⚠️ Invalid file at index {$fileIndex}");
                        continue;
                    }

                    $filename = time() . '_' . Str::random(8) . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), '_') . '.' . $file->getClientOriginalExtension();
                    $path = "desa/{$klasterSlug}/{$tahun}/{$filename}";

                    Log::info("⬆️ Uploading file {$fileIndex}", [
                        'original_name' => $file->getClientOriginalName(),
                        'path' => $path
                    ]);

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
                        Log::error('❌ Gagal upload ke Supabase', [
                            'file' => $filename,
                            'error' => $response->body(),
                            'status' => $response->status()
                        ]);
                        continue;
                    }

                    $penilaianId = Penilaian::where([
                        'desa_id' => $desaId,
                        'indikator_id' => $kategori->indikator_id,
                        'tahun' => $tahun,
                    ])->value('id');

                    if ($penilaianId) {
                        BerkasUpload::create([
                            'penilaian_id' => $penilaianId,
                            'kategori_upload_id' => $kategori->id,
                            'path_file' => $path,
                            'nilai' => 0,
                        ]);

                        Log::info("✅ File uploaded successfully", [
                            'file_index' => $fileIndex,
                            'path' => $path,
                            'kategori_id' => $kategori->id,
                            'penilaian_id' => $penilaianId
                        ]);
                    } else {
                        Log::error("❌ Penilaian tidak ditemukan", [
                            'desa_id' => $desaId,
                            'indikator_id' => $kategori->indikator_id,
                            'tahun' => $tahun
                        ]);
                    }

                    usleep(100000);
                }
            }

            DB::commit();
            return back()->with('success', "✅ {$savedCount} penilaian tahun {$tahun} berhasil disimpan!");
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('❌ Error saat menyimpan penilaian', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', '❌ Terjadi kesalahan: ' . $e->getMessage());
        }
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

        try {
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
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Batalkan penilaian 1 klaster (tahun berjalan saja)
     */
    public function cancelByKlaster($klasterId)
    {
        $user = Auth::user();
        $tahun = now()->year;

        $penilaians = Penilaian::where('desa_id', $user->desa_id)
            ->where('klaster_id', $klasterId)
            ->where('tahun', $tahun)
            ->get();

        if ($penilaians->isEmpty()) {
            return back()->with('error', 'Tidak ada penilaian tahun ini untuk klaster ini.');
        }

        if ($penilaians->contains(fn($p) => $p->status === 'approved')) {
            return back()->with('error', 'Tidak bisa membatalkan karena penilaian tahun ini sudah disetujui.');
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

            return back()->with('success', '🗑️ Penilaian tahun ini untuk klaster ini berhasil dibatalkan.');
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

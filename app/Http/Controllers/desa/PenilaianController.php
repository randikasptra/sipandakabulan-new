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
use Illuminate\Support\Str;

class PenilaianController extends Controller
{
    public function store(Request $request)
    {
        $desaId = Auth::user()->desa_id;
        $userId = Auth::id();

        foreach ($request->all() as $key => $value) {
            if (Str::startsWith($key, 'indikator_')) {
                $indikatorId = Str::after($key, 'indikator_');
                $indikator = IndikatorKlaster::find($indikatorId);
                if (!$indikator) {
                    continue;
                }

                // Cari penilaian desa-klaster-tahun ini
                $existing = Penilaian::where([
                    'desa_id' => $desaId,
                    'klaster_id' => $indikator->klaster_id,
                    'indikator_id' => $indikatorId,
                    'tahun' => now()->year,
                ])->first();

                // Kalau sudah approved, skip
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
            }
        }

        // 🔹 Upload file ke Supabase Storage
        foreach ($request->files as $key => $file) {
            if (Str::startsWith($key, 'file_') && $file !== null) {
                $kategoriId = Str::after($key, 'file_');
                $kategori = KategoriUpload::find($kategoriId);
                if (!$kategori) {
                    continue;
                }

                $filename = time() . '_' . $file->getClientOriginalName();
                $indikator = \App\Models\IndikatorKlaster::find($kategori->indikator_id);
                $klaster = $indikator?->klaster;
                $klasterSlug = $klaster ? Str::slug($klaster->slug ?? $klaster->title, '-') : 'unknown';

                $path = "desa/{$klasterSlug}/{$filename}";

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
                    \Log::error('Gagal upload ke Supabase', [
                        'file' => $filename,
                        'error' => $response->body(),
                    ]);
                    continue;
                }

                $penilaianId = Penilaian::where([
                    'desa_id' => $desaId,
                    'indikator_id' => $kategori->indikator_id,
                    'tahun' => now()->year,
                ])->value('id');

                BerkasUpload::create([
                    'penilaian_id' => $penilaianId,
                    'kategori_upload_id' => $kategori->id,
                    'path_file' => $path,
                    'nilai' => 0,
                ]);
            }
        }

        return redirect()->back()->with('success', '✅ Penilaian berhasil disimpan & file diunggah!');
    }
}

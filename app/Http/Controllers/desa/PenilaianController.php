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
        // 1️⃣ Simpan nilai indikator
        foreach ($request->all() as $key => $value) {
            if (Str::startsWith($key, 'indikator_')) {
                $indikatorId = Str::after($key, 'indikator_');

                // Ambil klaster_id dari indikator
                $indikator = IndikatorKlaster::find($indikatorId);
                if (!$indikator) {
                    continue; // skip jika tidak ditemukan
                }

                Penilaian::updateOrCreate(
                    [
                        'indikator_id' => $indikatorId,
                        'user_id' => Auth::id(),
                    ],
                    [
                        'klaster_id' => $indikator->klaster_id,
                        'nilai' => $value,
                        'tahun' => now()->year,
                        'bulan' => now()->format('F'),
                    ]
                );
            }
        }

        // 2️⃣ Upload file ke Supabase Storage (tanpa package)
        foreach ($request->files as $key => $file) {
            if (Str::startsWith($key, 'file_') && $file !== null) {
                $kategoriId = Str::after($key, 'file_');
                $kategori = KategoriUpload::find($kategoriId);

                if (!$kategori) {
                    continue;
                }

                $filename = time() . '_' . $file->getClientOriginalName();

                // Ambil indikator dan klaster untuk struktur folder
                $indikator = $kategori->indikator ?? $kategori->indikatorUpload ?? null;
                if (!$indikator) {
                    $indikator = \App\Models\IndikatorKlaster::find($kategori->indikator_id);
                }

                $klaster = $indikator?->klaster ?? null;

                // Pastikan punya slug klaster
                $klasterSlug = $klaster ? Str::slug($klaster->slug ?? $klaster->title, '-') : 'unknown';

                // Struktur path → desa/klasterX/{nama_file}
                $path = "desa/{$klasterSlug}/{$filename}";


                // Upload file via HTTP PUT ke Supabase Storage
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . env('SUPABASE_SERVICE_ROLE_KEY'),
                    'Content-Type' => $file->getClientMimeType(),
                ])->withBody(
                    file_get_contents($file->getRealPath()),
                    $file->getClientMimeType()
                )->put(
                    env('SUPABASE_URL') . '/storage/v1/object/' . env('SUPABASE_STORAGE_BUCKET') . '/' . $path
                );

                // Jika gagal, log error tapi lanjut ke file berikutnya
                if ($response->failed()) {
                    \Log::error('Gagal upload ke Supabase', [
                        'file' => $filename,
                        'error' => $response->body(),
                    ]);
                    continue;
                }

                // 3️⃣ Simpan info file ke tabel berkas_uploads
                BerkasUpload::create([
                    'penilaian_id' => Penilaian::where('indikator_id', $kategori->indikator_id)
                        ->where('user_id', Auth::id())
                        ->value('id'),
                    'kategori_upload_id' => $kategori->id,
                    'path_file' => $path,
                    'nilai' => 0,
                ]);
            }
        }

        return redirect()->back()->with('success', '✅ Penilaian dan file berhasil disimpan ke Supabase!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class AdminPengumumanController extends Controller
{
    public function index()
    {
        $pengumumans = Pengumuman::latest()->paginate(15);
        return view('pages.admin.pengumuman', compact('pengumumans'));
    }

    public function create()
    {
        $desas = Desa::orderBy('nama_desa')->get();
        return view('pages.admin.pengumuman-create', compact('desas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'isi' => 'required',
            'desa_ids' => 'required|array|min:1',
            'desa_ids.*' => 'exists:desas,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $filePath = null;

        // ========== UPLOAD KE SUPABASE =============
        if ($request->hasFile('file')) {

            $file = $request->file('file');

            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-_\.]/', '_', $file->getClientOriginalName());
            $path = "pengumuman/" . $filename;

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('SUPABASE_SERVICE_ROLE_KEY'),
                'Content-Type'  => $file->getClientMimeType(),
            ])->withBody(
                file_get_contents($file->getRealPath()),
                $file->getClientMimeType()
            )->put(
                env('SUPABASE_URL') . '/storage/v1/object/' . env('SUPABASE_STORAGE_BUCKET') . '/' . $path
            );

            if ($response->failed()) {
                return back()->with('error', '❌ Gagal upload file ke Supabase.');
            }

            $filePath = $path;
        }

        Pengumuman::create([
            'judul' => $validated['judul'],
            'isi' => $validated['isi'],
            'desa_ids' => array_map('intval', $validated['desa_ids']),
            'file' => $filePath,
        ]);

        return redirect()->route('admin.pengumuman')->with('success', 'Pengumuman berhasil dibuat!');
    }

    public function edit(Pengumuman $pengumuman)
    {
        $desas = Desa::orderBy('nama_desa')->get();
        $selected = $pengumuman->desa_ids; // Array dari cast

        return view('pages.admin.pengumuman-edit', compact('pengumuman', 'desas', 'selected'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $validated = $request->validate([
            'judul' => 'required|max:255',
            'isi' => 'required',
            'desa_ids' => 'required|array|min:1',
            'desa_ids.*' => 'exists:desas,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $filePath = $pengumuman->file;

        // ======== FILE BARU DIUPLOAD =========
        if ($request->hasFile('file')) {

            // Hapus file lama jika ada
            if ($pengumuman->file) {
                Http::withHeaders([
                    'Authorization' => 'Bearer ' . env('SUPABASE_SERVICE_ROLE_KEY')
                ])->delete(
                    env('SUPABASE_URL') . '/storage/v1/object/' . env('SUPABASE_STORAGE_BUCKET') . '/' . $pengumuman->file
                );
            }

            $file = $request->file('file');

            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-_\.]/', '_', $file->getClientOriginalName());
            $path = "pengumuman/" . $filename;

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('SUPABASE_SERVICE_ROLE_KEY'),
                'Content-Type'  => $file->getClientMimeType(),
            ])->withBody(
                file_get_contents($file->getRealPath()),
                $file->getClientMimeType()
            )->put(
                env('SUPABASE_URL') . '/storage/v1/object/' . env('SUPABASE_STORAGE_BUCKET') . '/' . $path
            );

            if ($response->failed()) {
                return back()->with('error', '❌ Gagal upload file ke Supabase.');
            }

            $filePath = $path;
        }

        $pengumuman->update([
            'judul' => $validated['judul'],
            'isi' => $validated['isi'],
            'desa_ids' => array_map('intval', $validated['desa_ids']),
            'file' => $filePath,
        ]);

        return redirect()->route('admin.pengumuman')->with('success', 'Pengumuman berhasil diperbarui!');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        // Hapus file jika ada
        if ($pengumuman->file) {
            Storage::disk('supabase')->delete($pengumuman->file);
        }

        $pengumuman->delete();

        return redirect()
            ->route('admin.pengumuman')
            ->with('success', '🗑️ Pengumuman berhasil dihapus!');
    }
}

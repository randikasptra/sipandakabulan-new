<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        // Upload file ke Supabase (jika ada)
        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'pengumuman/' . $fileName;
            Storage::disk('supabase')->put($filePath, file_get_contents($file));
        }

        // ✅ FIX: Convert desa_ids ke array of strings untuk konsistensi
        $desaIds = array_map('strval', $validated['desa_ids']);

        Pengumuman::create([
            'judul' => $validated['judul'],
            'isi' => $validated['isi'],
            'desa_ids' => $desaIds, // Simpan sebagai array string
            'file' => $filePath,
        ]);

        return redirect()
            ->route('admin.pengumuman')
            ->with('success', '✅ Pengumuman berhasil dibuat!');
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

        // Handle file upload
        $filePath = $pengumuman->file; // Keep old file

        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($pengumuman->file) {
                Storage::disk('supabase')->delete($pengumuman->file);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'pengumuman/' . $fileName;
            Storage::disk('supabase')->put($filePath, file_get_contents($file));
        }

        $pengumuman->update([
            'judul' => $validated['judul'],
            'isi' => $validated['isi'],
            'desa_ids' => $validated['desa_ids'],
            'file' => $filePath,
        ]);

        return redirect()
            ->route('admin.pengumuman')
            ->with('success', '✅ Pengumuman berhasil diupdate!');
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminDesaController extends Controller
{
    /**
     * List semua desa
     */
    public function index()
    {
        $desas = Desa::with('users')->get();
        return view('pages.admin.desa', compact('desas'));
    }

    /**
     * Form tambah desa
     */
    public function create()
    {
        return view('pages.admin.desa-create');
    }

    /**
     * Simpan desa + auto create user
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_desa' => 'required|string|max:255',
            'kode_desa' => 'required|string|max:50|unique:desas,kode_desa',
            'alamat_kantor' => 'nullable|string',
            'nama_kades' => 'nullable|string|max:255',
            'no_telp' => 'nullable|string|max:30',
        ]);

        // 1) SIMPAN DESA
        $desa = Desa::create($request->only([
            'nama_desa', 'kode_desa', 'alamat_kantor', 'nama_kades', 'no_telp'
        ]));

        // 2) GENERATE EMAIL
        $email = Str::slug($desa->nama_desa) . '@tasikdesa.com';

        // 3) GENERATE PASSWORD RANDOM
        $password = 'desa-' . rand(1000, 9999);

        // 4) SIMPAN USER DESA
        $user = User::create([
            'name' => $desa->nama_desa,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'desa',
            'desa_id' => $desa->id,
        ]);

        // 5) KIRIM PASSWORD KE VIEW
        return redirect()->route('desa.index')->with([
        'success' => 'Desa & User berhasil dibuat!',
        'desa_user_email' => $email,
        'desa_user_password' => $password,
    ]);
    }

    /**
     * Detail desa
     */
    public function show(Desa $desa)
    {
        $desa->load('users');
        return view('pages.admin.desa-detail', compact('desa'));
    }

    /**
     * Form edit desa
     */
    public function edit(Desa $desa)
    {
        return view('pages.admin.desa-edit', compact('desa'));
    }

    /**
     * Update desa
     */
    public function update(Request $request, Desa $desa)
    {
        $request->validate([
            'nama_desa' => 'required|string|max:255',
            'kode_desa' => 'required|string|max:50|unique:desas,kode_desa,' . $desa->id,
            'alamat_kantor' => 'nullable|string',
            'nama_kades' => 'nullable|string|max:255',
            'no_telp' => 'nullable|string|max:30',
        ]);

        $desa->update($request->all());

        return redirect()->route('desa.index')->with('success', 'Desa berhasil diupdate!');
    }

    /**
     * Hapus desa + hapus user (SARAN TERBAIK)
     */
    public function destroy(Desa $desa)
    {
        // Hapus semua user desa
        User::where('desa_id', $desa->id)->delete();

        // Hapus desa
        $desa->delete();

        return redirect()->route('desa.index')->with('success', 'Desa dan pengguna desa berhasil dihapus.');
    }
}

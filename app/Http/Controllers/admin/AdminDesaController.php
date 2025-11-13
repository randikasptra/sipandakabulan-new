<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminDesaController extends Controller
{
    public function index()
    {
        $desas = Desa::with('users')->get();
        return view('pages.admin.desa', compact('desas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_desa' => 'required|string|max:255',
            'kode_desa' => 'required|string|max:50|unique:desas,kode_desa',
            'alamat_kantor' => 'nullable|string',
            'nama_kades' => 'nullable|string|max:255',
            'no_telp' => 'nullable|string|max:30',
        ]);

        $desa = Desa::create($request->all());

        $email = Str::slug($desa->nama_desa) . '@tasikdesa.com';
        $password = 'desa-' . rand(1000, 9999);

        User::create([
            'name' => $desa->nama_desa,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'desa',
            'desa_id' => $desa->id,
        ]);

        return back()->with([
            'success' => 'Desa berhasil ditambahkan',
            'desa_user_email' => $email,
            'desa_user_password' => $password,
        ]);
    }

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

        return back()->with('success', 'Desa berhasil diperbarui');
    }

    public function destroy(Desa $desa)
    {
        User::where('desa_id', $desa->id)->delete();
        $desa->delete();

        return back()->with('success', 'Desa dan user terkait berhasil dihapus');
    }

    // ========== AJAX DETAIL MODAL ==========
    public function ajaxDetail(Desa $desa)
    {
        $desa->load('users');
        return view('components.admin.desa.detail-content', compact('desa'));
    }

    // ========== AJAX EDIT MODAL ==========
    public function ajaxEdit(Desa $desa)
    {
        return view('components.admin.desa.edit-content', compact('desa'));
    }
    public function create()
    {
        return view('pages.admin.desa-create');
    }

    public function edit(Desa $desa)
    {
        return view('pages.admin.desa-edit', compact('desa'));
    }

}

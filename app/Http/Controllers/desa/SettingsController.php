<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    /**
     * Tampilkan halaman settings
     */
    public function index()
    {
        $user = Auth::user();
        $desa = $user->desa;

        return view('pages.desa.settings', compact('user', 'desa'));
    }

    /**
     * Update profil user
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update password user
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.current_password' => 'Password lama tidak sesuai.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }

    /**
     * Update data desa
     */
    public function updateDesa(Request $request)
    {
        $user = Auth::user();

        if (!$user->desa) {
            return back()->with('error', 'Data desa tidak ditemukan.');
        }

        $validated = $request->validate([
            'nama_desa' => ['required', 'string', 'max:255'],
            'kode_desa' => ['nullable', 'string', 'max:50'],
            'alamat_kantor' => ['nullable', 'string', 'max:500'],
            'nama_kades' => ['nullable', 'string', 'max:255'],
            'no_telp' => ['nullable', 'string', 'max:20'],
        ]);

        $user->desa->update($validated);

        return back()->with('success', 'Data desa berhasil diperbarui!');
    }
}

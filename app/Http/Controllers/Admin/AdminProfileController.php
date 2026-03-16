<?php
// app/Http/Controllers/Admin/AdminProfileController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminProfileController extends Controller
{
    /**
     * Tampilkan halaman profil admin
     */
    public function index()
    {
        return view('pages.admin.profile.index');
    }

    /**
     * Update profil admin (nama & email)
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ], [
            'name.required' => 'Nama wajib diisi',
            'name.max' => 'Nama maksimal 255 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('tab', 'profile');
        }

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            return redirect()->route('admin.profile')
                ->with('success', '✅ Profil berhasil diperbarui!')
                ->with('tab', 'profile');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', '❌ Gagal memperbarui profil: ' . $e->getMessage())
                ->withInput()
                ->with('tab', 'profile');
        }
    }

    /**
     * Update password admin
     */
    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'new_password.required' => 'Password baru wajib diisi',
            'new_password.min' => 'Password minimal 8 karakter',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        // Validasi password saat ini
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Password saat ini salah'])
                ->with('tab', 'password');
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('tab', 'password');
        }

        try {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);

            return redirect()->route('admin.profile')
                ->with('success', '✅ Password berhasil diubah!')
                ->with('tab', 'password');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', '❌ Gagal mengubah password: ' . $e->getMessage())
                ->with('tab', 'password');
        }
    }
}
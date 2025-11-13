<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminDesaController extends Controller
{
    /**
     * Display a listing of desa
     */
    public function index()
    {
        $desas = Desa::with('users')
            ->withCount('penilaians')
            ->latest()
            ->paginate(10);

        return view('pages.admin.desa', compact('desas'));
    }

    /**
     * Show the form for creating a new desa
     */
    public function create()
    {
        return view('pages.admin.desa-create');
    }

    /**
     * Store a newly created desa
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_desa' => 'required|string|max:255',
            'kode_desa' => 'required|string|max:50|unique:desas,kode_desa',
            'alamat_kantor' => 'nullable|string|max:500',
            'nama_kades' => 'nullable|string|max:255',
            'no_telp' => 'nullable|string|max:20',
        ]);

        DB::beginTransaction();
        try {
            // Create Desa
            $desa = Desa::create($validated);

            // Generate email & password
            $email = Str::slug($desa->nama_desa) . '@tasikdesa.com';
            $password = 'password123';

            // Create default user operator
            User::create([
                'name' => 'Operator ' . $desa->nama_desa,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'desa',
                'desa_id' => $desa->id,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.desa')
                ->with('success', 'Desa berhasil ditambahkan')
                ->with('show_credentials', true)
                ->with('credentials', [
                    'nama_desa' => $desa->nama_desa,
                    'email' => $email,
                    'password' => $password,
                ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan desa: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing desa + manage users
     */
    public function edit(Desa $desa)
    {
        $desa->load('users');
        return view('pages.admin.desa-edit', compact('desa'));
    }

    /**
     * Update the specified desa
     */
    public function update(Request $request, Desa $desa)
    {
        $validated = $request->validate([
            'nama_desa' => 'required|string|max:255',
            'kode_desa' => [
                'required',
                'string',
                'max:50',
                Rule::unique('desas', 'kode_desa')->ignore($desa->id)
            ],
            'alamat_kantor' => 'nullable|string|max:500',
            'nama_kades' => 'nullable|string|max:255',
            'no_telp' => 'nullable|string|max:20',
        ]);

        try {
            $desa->update($validated);

            return back()->with('success', 'Data desa berhasil diperbarui');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui desa: ' . $e->getMessage());
        }
    }

    /**
     * Soft delete desa
     */
    public function destroy(Desa $desa)
    {
        try {
            $desa->delete(); // Soft delete

            return redirect()
                ->route('admin.desa')
                ->with('success', 'Desa berhasil dihapus');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus desa: ' . $e->getMessage());
        }
    }

    // ========================================
    // USER MANAGEMENT (dalam halaman edit)
    // ========================================

    /**
     * Add new user for desa
     */
    public function addUser(Request $request, Desa $desa)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        try {
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make('password123'),
                'role' => 'desa',
                'desa_id' => $desa->id,
            ]);

            return back()
                ->with('success', 'User berhasil ditambahkan')
                ->with('show_credentials', true)
                ->with('credentials', [
                    'nama_desa' => $desa->nama_desa,
                    'email' => $validated['email'],
                    'password' => 'password123',
                ]);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan user: ' . $e->getMessage());
        }
    }

    /**
     * Update user email
     */
    public function updateUser(Request $request, Desa $desa, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id)
            ],
        ]);

        try {
            $user->update($validated);

            return back()->with('success', 'User berhasil diperbarui');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui user: ' . $e->getMessage());
        }
    }

    /**
     * Reset password user
     */
    public function resetPassword(Desa $desa, User $user)
    {
        try {
            $newPassword = 'password123';
            $user->update([
                'password' => Hash::make($newPassword)
            ]);

            return back()
                ->with('success', 'Password berhasil direset')
                ->with('show_credentials', true)
                ->with('credentials', [
                    'nama_desa' => $desa->nama_desa,
                    'email' => $user->email,
                    'password' => $newPassword,
                ]);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal reset password: ' . $e->getMessage());
        }
    }

    /**
     * Delete user
     */
    public function deleteUser(Desa $desa, User $user)
    {
        try {
            // Cek jika user terakhir
            if ($desa->users()->count() <= 1) {
                return back()->with('error', 'Tidak bisa menghapus user terakhir');
            }

            $user->delete();

            return back()->with('success', 'User berhasil dihapus');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }

    // ========================================
    // AJAX METHODS (untuk modal jika perlu)
    // ========================================

    public function ajaxDetail(Desa $desa)
    {
        $desa->load('users');
        return view('components.admin.desa.detail-content', compact('desa'));
    }

    public function ajaxEdit(Desa $desa)
    {
        return view('components.admin.desa.edit-content', compact('desa'));
    }
}

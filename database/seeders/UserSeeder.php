<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Desa;

class UserSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk user dan desa Tasikmalaya
     */
    public function run(): void
    {
        // 🧑‍💼 Admin pusat
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Dinsos Kabupaten Tasikmalaya',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // 📋 Daftar desa di Kabupaten Tasikmalaya (contoh 10 desa dari berbagai kecamatan)
        $desas = [
            ['nama_desa' => 'Desa Sukarame', 'nama_kades' => 'Ujang Saepudin', 'kode_desa' => 'DS001', 'alamat_kantor' => 'Kec. Sukarame', 'no_telp' => '081234560001'],
            ['nama_desa' => 'Desa Cisayong', 'nama_kades' => 'Yayan Suryana', 'kode_desa' => 'DS002', 'alamat_kantor' => 'Kec. Cisayong', 'no_telp' => '081234560002'],
            ['nama_desa' => 'Desa Singaparna', 'nama_kades' => 'Dedi Ruhimat', 'kode_desa' => 'DS003', 'alamat_kantor' => 'Kec. Singaparna', 'no_telp' => '081234560003'],
            ['nama_desa' => 'Desa Manonjaya', 'nama_kades' => 'Asep Hidayat', 'kode_desa' => 'DS004', 'alamat_kantor' => 'Kec. Manonjaya', 'no_telp' => '081234560004'],
            ['nama_desa' => 'Desa Rajapolah', 'nama_kades' => 'Endang Permana', 'kode_desa' => 'DS005', 'alamat_kantor' => 'Kec. Rajapolah', 'no_telp' => '081234560005'],
            ['nama_desa' => 'Desa Leuwisari', 'nama_kades' => 'Tatang Ruhimat', 'kode_desa' => 'DS006', 'alamat_kantor' => 'Kec. Leuwisari', 'no_telp' => '081234560006'],
            ['nama_desa' => 'Desa Cigalontang', 'nama_kades' => 'Oman Supardi', 'kode_desa' => 'DS007', 'alamat_kantor' => 'Kec. Cigalontang', 'no_telp' => '081234560007'],
            ['nama_desa' => 'Desa Tanjungjaya', 'nama_kades' => 'Yudi Ahmad', 'kode_desa' => 'DS008', 'alamat_kantor' => 'Kec. Tanjungjaya', 'no_telp' => '081234560008'],
            ['nama_desa' => 'Desa Sukaratu', 'nama_kades' => 'Rudi Hermawan', 'kode_desa' => 'DS009', 'alamat_kantor' => 'Kec. Sukaratu', 'no_telp' => '081234560009'],
            ['nama_desa' => 'Desa Puspahiang', 'nama_kades' => 'Ayi Mulyana', 'kode_desa' => 'DS010', 'alamat_kantor' => 'Kec. Puspahiang', 'no_telp' => '081234560010'],
        ];

        // 🏡 Insert desa dan user-nya
        foreach ($desas as $desaData) {
            $desa = Desa::firstOrCreate(
                ['nama_desa' => $desaData['nama_desa']],
                [
                    'kode_desa' => $desaData['kode_desa'],
                    'alamat_kantor' => $desaData['alamat_kantor'],
                    'nama_kades' => $desaData['nama_kades'],
                    'no_telp' => $desaData['no_telp'],
                ]
            );

            // Buat akun operator per desa
            User::firstOrCreate(
                ['email' => strtolower(str_replace(' ', '', $desaData['nama_desa'])) . '@tasikdesa.com'],
                [
                    'name' => 'Operator ' . $desaData['nama_desa'],
                    'password' => Hash::make('password123'),
                    'role' => 'desa',
                    'desa_id' => $desa->id,
                ]
            );
        }
    }
}

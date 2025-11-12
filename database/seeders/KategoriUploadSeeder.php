<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriUploadSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategori_uploads')->insert([
            // Klaster 1 - Anak Akta Kelahiran (indikator_id = 1)
            [
                'indikator_id' => 1,
                'nama_kategori' => '0–60 hari',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'indikator_id' => 1,
                'nama_kategori' => '61 hari – 1 tahun',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'indikator_id' => 1,
                'nama_kategori' => '1 – < 5 tahun',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'indikator_id' => 1,
                'nama_kategori' => '5 – < 12 tahun',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'indikator_id' => 1,
                'nama_kategori' => '12 – < 18 tahun',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Klaster 2 - Perkawinan Anak (indikator_id = 3)
            [
                'indikator_id' => 3,
                'nama_kategori' => 'KUA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'indikator_id' => 3,
                'nama_kategori' => 'Organisasi Agama',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'indikator_id' => 3,
                'nama_kategori' => 'Catatan Sipil',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'indikator_id' => 3,
                'nama_kategori' => 'Lembaga Adat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'indikator_id' => 3,
                'nama_kategori' => 'Pengadilan Agama',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriUploadSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategori_uploads')->insert([
            // Klaster 1 - Anak Akta Kelahiran
            ['indikator_id' => 1, 'nama' => '0–60 hari'],
            ['indikator_id' => 1, 'nama' => '61 hari – 1 tahun'],
            ['indikator_id' => 1, 'nama' => '1 – < 5 tahun'],
            ['indikator_id' => 1, 'nama' => '5 – < 12 tahun'],
            ['indikator_id' => 1, 'nama' => '12 – < 18 tahun'],

            // Klaster 2 - Perkawinan Anak
            ['indikator_id' => 3, 'nama' => 'KUA'],
            ['indikator_id' => 3, 'nama' => 'Organisasi Agama'],
            ['indikator_id' => 3, 'nama' => 'Catatan Sipil'],
            ['indikator_id' => 3, 'nama' => 'Lembaga Adat'],
            ['indikator_id' => 3, 'nama' => 'Pengadilan Agama'],
        ]);
    }
}

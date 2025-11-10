<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndikatorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('indikator_klaster')->insert([
            [
                'klaster_id' => 2,
                'nama_indikator' => 'Anak Akta Kelahiran',
                'slug' => 'anak_akta_kelahiran',
                'deskripsi' => null,
                'total_nilai' => 60,
                'template_excel' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'klaster_id' => 2,
                'nama_indikator' => 'Anggaran Anak',
                'slug' => 'anggaran_anak',
                'deskripsi' => null,
                'total_nilai' => 40,
                'template_excel' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'klaster_id' => 3,
                'nama_indikator' => 'Perkawinan Anak',
                'slug' => 'perkawinan_anak',
                'deskripsi' => null,
                'total_nilai' => 30,
                'template_excel' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'klaster_id' => 3,
                'nama_indikator' => 'Pencegahan Pernikahan Dini',
                'slug' => 'pencegahan_pernikahan_dini',
                'deskripsi' => null,
                'total_nilai' => 30,
                'template_excel' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'klaster_id' => 3,
                'nama_indikator' => 'Lembaga Konsultasi',
                'slug' => 'lembaga_konsultasi',
                'deskripsi' => null,
                'total_nilai' => 40,
                'template_excel' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

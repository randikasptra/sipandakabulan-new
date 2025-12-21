<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Klaster;
use Illuminate\Support\Facades\DB;

class KlasterSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama terlebih dahulu
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Klaster::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Atau bisa juga pakai:
        // Klaster::query()->delete();

        // Insert data baru
        Klaster::insert([
            [
                'title' => 'Kelembagaan',
                'slug' => 'kelembagaan',
                'nilai_em' => 0,
                'nilai_maksimal' => 260,
                'progres' => 0,
            ],
            [
                'title' => 'Klaster I: Hak Sipil dan Kebebasan',
                'slug' => 'klaster1',
                'nilai_em' => 0,
                'nilai_maksimal' => 120,
                'progres' => 0,
            ],
            [
                'title' => 'Klaster II: Lingkungan Keluarga dan Pengasuhan Alternatif',
                'slug' => 'klaster2',
                'nilai_em' => 0,
                'nilai_maksimal' => 100,
                'progres' => 0,
            ],
            [
                'title' => 'Klaster III: Kesehatan Dasar dan Kesejahteraan',
                'slug' => 'klaster3',
                'nilai_em' => 0,
                'nilai_maksimal' => 180,
                'progres' => 0,
            ],
            [
                'title' => 'Klaster IV: Pendidikan, Waktu Luang dan Budaya',
                'slug' => 'klaster4',
                'nilai_em' => 0,
                'nilai_maksimal' => 230,
                'progres' => 0,
            ],
            [
                'title' => 'Klaster V: Perlindungan Khusus',
                'slug' => 'klaster5',
                'nilai_em' => 0,
                'nilai_maksimal' => 130,
                'progres' => 0,
            ],
        ]);
    }
}
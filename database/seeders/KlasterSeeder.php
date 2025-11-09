<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KlasterSeeder extends Seeder
{
    public function run(): void
    {
        $klasters = [
            ['nama' => 'Kelembagaan', 'kode' => 'kelembagaan', 'deskripsi' => 'Kelembagaan pendukung KLA'],
            ['nama' => 'Klaster I: Hak Sipil dan Kebebasan', 'kode' => 'klaster1', 'deskripsi' => 'Pemenuhan hak sipil anak'],
            ['nama' => 'Klaster II: Lingkungan Keluarga dan Pengasuhan Alternatif', 'kode' => 'klaster2', 'deskripsi' => 'Kesejahteraan keluarga'],
            ['nama' => 'Klaster III: Kesehatan Dasar dan Kesejahteraan', 'kode' => 'klaster3', 'deskripsi' => null],
            ['nama' => 'Klaster IV: Pendidikan, Waktu Luang dan Budaya', 'kode' => 'klaster4', 'deskripsi' => null],
            ['nama' => 'Klaster V: Perlindungan Khusus', 'kode' => 'klaster5', 'deskripsi' => null],
        ];

        DB::table('klasters')->insert($klasters);
    }
}

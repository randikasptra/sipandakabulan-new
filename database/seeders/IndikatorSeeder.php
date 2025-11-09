<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndikatorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('indikator_klaster')->insert([
            ['klaster_id' => 2, 'nama' => 'Anak Akta Kelahiran', 'bobot' => 60],
            ['klaster_id' => 2, 'nama' => 'Anggaran Anak', 'bobot' => 40],
            ['klaster_id' => 3, 'nama' => 'Perkawinan Anak', 'bobot' => 30],
            ['klaster_id' => 3, 'nama' => 'Pencegahan Pernikahan Dini', 'bobot' => 30],
            ['klaster_id' => 3, 'nama' => 'Lembaga Konsultasi', 'bobot' => 40],
        ]);
    }
}

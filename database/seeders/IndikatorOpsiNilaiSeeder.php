<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndikatorOpsiNilaiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('indikator_opsi_nilai')->insert([
            ['indikator_id' => 1, 'label' => '≤10%', 'nilai' => 0],
            ['indikator_id' => 1, 'label' => '10–20%', 'nilai' => 20],
            ['indikator_id' => 1, 'label' => '20–80%', 'nilai' => 40],
            ['indikator_id' => 1, 'label' => '80–100%', 'nilai' => 60],
        ]);
    }
}

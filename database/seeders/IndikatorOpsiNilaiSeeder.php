<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndikatorOpsiNilaiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('indikator_opsi_nilai')->insert([
            [
                'indikator_id' => 1,
                'label' => '≤10%',
                'poin' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'indikator_id' => 1,
                'label' => '10–20%',
                'poin' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'indikator_id' => 1,
                'label' => '20–80%',
                'poin' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'indikator_id' => 1,
                'label' => '80–100%',
                'poin' => 60,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

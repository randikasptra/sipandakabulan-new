<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// ✅ Tambahkan semua ini
use Database\Seeders\KlasterSeeder;
use Database\Seeders\IndikatorSeeder;
use Database\Seeders\IndikatorOpsiNilaiSeeder;
use Database\Seeders\KategoriUploadSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            KlasterSeeder::class,
            IndikatorSeeder::class,
            IndikatorOpsiNilaiSeeder::class,
            KategoriUploadSeeder::class,
        ]);
    }
}

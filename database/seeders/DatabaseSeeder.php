<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// ✅ Tambahkan semua ini
use Database\Seeders\KlasterSeeder;
use Database\Seeders\IndikatorSeeder;
use Database\Seeders\IndikatorOpsiNilaiSeeder;
use Database\Seeders\KategoriUploadSeeder;
use Database\Seeders\KelembagaanSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            KlasterSeeder::class,
            IndikatorSeeder::class,
            IndikatorOpsiNilaiSeeder::class,
            KategoriUploadSeeder::class,
            KelembagaanSeeder::class,
            Klaster1Seeder::class,
            Klaster2Seeder::class,
            Klaster3Seeder::class,
            Klaster4Seeder::class,
            Klaster5Seeder::class,
        ]);
    }
}

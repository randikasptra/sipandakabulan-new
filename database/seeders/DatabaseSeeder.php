<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// ✅ Tambahkan semua ini
use Database\Seeders\KlasterSeeder;
use Database\Seeders\IndikatorSeeder;
use Database\Seeders\IndikatorOpsiNilaiSeeder;
use Database\Seeders\KategoriUploadSeeder;
use Database\Seeders\KelembagaanSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\Klaster1Seeder;
use Database\Seeders\Klaster2Seeder;
use Database\Seeders\Klaster3Seeder;
use Database\Seeders\Klaster4Seeder;
use Database\Seeders\Klaster5Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            // KlasterSeeder::class,
            // IndikatorSeeder::class,
            // IndikatorOpsiNilaiSeeder::class,
            // KategoriUploadSeeder::class,
            KelembagaanSeeder::class,
            Klaster1Seeder::class,
            Klaster2Seeder::class,
            Klaster3Seeder::class,
            Klaster4Seeder::class,
            Klaster5Seeder::class,
        ]);
    }
}

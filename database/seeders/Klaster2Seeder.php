<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Klaster;
use App\Models\IndikatorKlaster;
use App\Models\IndikatorOpsiNilai;
use App\Models\KategoriUpload;

class Klaster2Seeder extends Seeder
{
    public function run(): void
    {
        // Tambah Klaster 2: Lingkungan Keluarga dan Pengasuhan Alternatif
        $klaster = Klaster::firstOrCreate(
            ['slug' => 'klaster2'],
            [
                'title' => 'Lingkungan Keluarga dan Pengasuhan Alternatif',
                'nilai_em' => 0,
                'nilai_maksimal' => 100,
                'progres' => 0,
            ]
        );

        // Data indikator klaster 2
        $indikators = [
            [
                'judul' => 'Apakah Ada Perkawinan Anak (Total Nilai 25)',
                'slug' => 'perkawinan_anak',
                'nilai' => 25,
                'template_excel' => 'PerkawinanAnak.xlsx',
                'opsi' => [
                    0 => 'Tidak Ada',
                    10 => '≤ 10%',
                    15 => '10% – 20%',
                    25 => '> 20%',
                ],
                'uploads' => [
                ],
            ],
            [
                'judul' => 'Upaya Untuk Pencegahan Pernikahan Anak (Total Nilai 45)',
                'slug' => 'pencegahan_pernikahan',
                'nilai' => 45,
                'template_excel' => null,
                'opsi' => [
                    0 => 'Tidak Ada',
                    15 => '1 – 3 Program',
                    45 => '≥ 4 Program',
                ],
                'uploads' => [
                ],
            ],
            [
                'judul' => 'Tersedia Lembaga Konsultasi Bagi Keluarga (Total Nilai 30)',
                'slug' => 'lembaga_konsultasi',
                'nilai' => 30,
                'template_excel' => 'LembagaKonsultasi.xlsx',
                'opsi' => [
                    15 => 'Tersedia 1 Lembaga',
                    25 => '≤ 3 Lembaga',
                    30 => '≥ 5 Lembaga',
                ],
                'uploads' => [
                ],
            ],
        ];

        foreach ($indikators as $indikatorData) {
            $indikator = IndikatorKlaster::create([
                'klaster_id' => $klaster->id,
                'nama_indikator' => $indikatorData['judul'],
                'slug' => $indikatorData['slug'],
                'total_nilai' => $indikatorData['nilai'],
                'template_excel' => $indikatorData['template_excel'],
            ]);

            foreach ($indikatorData['opsi'] as $poin => $label) {
                IndikatorOpsiNilai::create([
                    'indikator_id' => $indikator->id,
                    'label' => $label,
                    'poin' => $poin,
                ]);
            }

            foreach ($indikatorData['uploads'] as $uploadName) {
                KategoriUpload::create([
                    'indikator_id' => $indikator->id,
                    'nama_kategori' => $uploadName,
                ]);
            }
        }
    }
}

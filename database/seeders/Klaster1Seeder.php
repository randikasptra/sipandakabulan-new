<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Klaster;
use App\Models\IndikatorKlaster;
use App\Models\IndikatorOpsiNilai;
use App\Models\KategoriUpload;

class Klaster1Seeder extends Seeder
{
    public function run(): void
    {
        // Tambah Klaster 1: Hak Sipil dan Kebebasan
        $klaster = Klaster::firstOrCreate(
            ['slug' => 'klaster1'],
            [
                'title' => 'Hak Sipil dan Kebebasan',
                'nilai_em' => 0,
                'nilai_maksimal' => 120,
                'progres' => 0,
            ]
        );

        // Data indikator klaster 1
        $indikators = [
            [
                'judul' => '1. Anak Yang Memiliki Akta Kelahiran (Total Nilai 60)',
                'slug' => 'anak_akta_kelahiran',
                'nilai' => 60,
                'template_excel' => 'AnakAktaKelahiran.xlsx',
                'opsi' => [
                    0 => '≤ 10%',
                    20 => '10% – 20%',
                    40 => '20% – 80%',
                    60 => '80% – 100%',
                ],
                'uploads' => [
                    '0 – 60 hari',
                    '61 hari - 1 tahun',
                    '1 - < 5 tahun',
                    '5 - < 12 tahun',
                    '12 - < 18 tahun',
                ],
            ],
            [
                'judul' => '2. Anak Yang Memiliki Kartu Identitas Anak (Total Nilai 60)',
                'slug' => 'anak_kartu_identitas',
                'nilai' => 60,
                'template_excel' => null,
                'opsi' => [
                    0 => '≤ 10%',
                    20 => '10% – 20%',
                    40 => '20% – 80%',
                    60 => '80% – 100%',
                ],
                'uploads' => [
                    'Dokumen Kartu Identitas Anak',
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

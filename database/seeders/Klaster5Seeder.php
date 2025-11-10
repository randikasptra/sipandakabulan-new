<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Klaster;
use App\Models\IndikatorKlaster;
use App\Models\IndikatorOpsiNilai;
use App\Models\KategoriUpload;

class Klaster5Seeder extends Seeder
{
    public function run(): void
    {
        // Tambah Klaster 5: Perlindungan Khusus
        $klaster = Klaster::firstOrCreate(
            ['slug' => 'klaster5'],
            [
                'title' => 'Perlindungan Khusus',
                'nilai_em' => 0,
                'nilai_maksimal' => 130,
                'progres' => 0,
            ]
        );

        // Data indikator klaster 5
        $indikators = [
            [
                'judul' => '1. Laporan Kekerasan Terhadap Anak yang Dilayani dan Diselesaikan (Total Nilai 40)',
                'slug' => 'laporan_kekerasan_anak',
                'nilai' => 40,
                'template_excel' => 'LaporanKekerasanAnak.xlsx',
                'opsi' => [
                    10 => '0 – 10%',
                    25 => '> 25%',
                    40 => '> 50%',
                ],
                'uploads' => [
                    'Jumlah Anak Yang mendapatkan Kekerasan seksual',
                    'Jumlah Anak Yang Mendapatkan Kekerasan Fisik',
                    'Jumlah Perkawinan anak (dibawah 18 thn)',
                    'Jumlah Anak yang bekerja',
                    'Jumlah Anak yang berhadapan dengan hukum',
                    'Jumlah kasus anak yang diselesaikan',
                    'Jumlah Anak Keluarga Miskin Yang mendapat layanan program',
                ],
            ],
            [
                'judul' => '2. Apakah Ada Mekanisme Penanggulangan Bencana (Total Nilai 20)',
                'slug' => 'mekanisme_penanggulangan_bencana',
                'nilai' => 20,
                'template_excel' => null,
                'opsi' => [
                    0 => 'Tidak Ada',
                    20 => 'Ada dan Disosialisasikan',
                ],
                'uploads' => [
                    'Dokumen Mekanisme Penanggulangan Bencana',
                ],
            ],
            [
                'judul' => '3. Adakah Program Pencegahan Kekerasan pada Anak yang Dilaksanakan (Total Nilai 30)',
                'slug' => 'program_pencegahan_kekerasan',
                'nilai' => 30,
                'template_excel' => null,
                'opsi' => [
                    0 => 'Tidak Ada',
                    30 => 'Ada dan Disosialisasikan',
                ],
                'uploads' => [
                    'Dokumen Program Pencegahan Kekerasan pada Anak',
                ],
            ],
            [
                'judul' => '4. Apakah Ada Program Pencegahan Pekerjaan Anak (Total Nilai 40)',
                'slug' => 'program_pencegahan_pekerjaan_anak',
                'nilai' => 40,
                'template_excel' => null,
                'opsi' => [
                    0 => 'Tidak Ada',
                    20 => '≤ 3 Program',
                    40 => '4 – 5 Program',
                ],
                'uploads' => [
                    'Dokumen Program Pencegahan Pekerjaan Anak',
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

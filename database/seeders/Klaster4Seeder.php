<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Klaster;
use App\Models\IndikatorKlaster;
use App\Models\IndikatorOpsiNilai;
use App\Models\KategoriUpload;

class Klaster4Seeder extends Seeder
{
    public function run(): void
    {
        // Tambah Klaster 4: Pendidikan, Pemanfaatan Waktu Luang dan Kegiatan Budaya
        $klaster = Klaster::firstOrCreate(
            ['slug' => 'klaster4'],
            [
                'title' => 'Pendidikan, Pemanfaatan Waktu Luang dan Kegiatan Budaya',
                'nilai_em' => 0,
                'nilai_maksimal' => 270,
                'progres' => 0,
            ]
        );

        // Data indikator klaster 4
        $indikators = [
            [
                'judul' => 'Tersedia Fasilitas Informasi Layak Anak (Total Nilai 45)',
                'slug' => 'fasilitas_informasi',
                'nilai' => 45,
                'template_excel' => 'FasilitasInformasi.xlsx',
                'opsi' => [
                    0 => 'Tidak ada',
                    22 => 'Lebih dari 2 sampai 3 jenis',
                    45 => 'Lebih dari 4 jenis',
                ],
                'uploads' => [
                ],
            ],
            
            [
                'judul' => 'Partisipasi Anak Usia Dini (Total Nilai 30)',
                'slug' => 'partisipasi_dini',
                'nilai' => 30,
                'template_excel' => null,
                'opsi' => [
                    0 => 'Tidak ada',
                    30 => 'Ada',
                ],
                'uploads' => [
                ],
            ],
            [
                'judul' => 'Presentasi Belajar 12 Tahun (Total Nilai 50)',
                'slug' => 'belajar_12_tahun',
                'nilai' => 50,
                'template_excel' => null,
                'opsi' => [
                    0 => '≤ 10%',
                    25 => '≥ 25%',
                    40 => '≥ 50%',
                    50 => '100%',
                ],
                'uploads' => [
                ],
            ],
            [
                'judul' => 'Sekolah Ramah Anak (Total Nilai 20)',
                'slug' => 'sekolah_ramah_anak',
                'nilai' => 20,
                'template_excel' => null,

                'opsi' => [
                    0 => 'Tidak ada sekolah ramah anak',
                    5 => '≤ 3 komponen terpenuhi',
                    10 => '4–5 komponen',
                    15 => '6–8 komponen',
                    20 => '9–10 komponen',
                ],
                'uploads' => [
                ],
            ],
            [
                'judul' => 'Fasilitas Kreativitas Anak di Luar Sekolah (Total Nilai 45)',
                'slug' => 'fasilitas_kreativitas',
                'nilai' => 45,
                'template_excel' => null,

                'opsi' => [
                    0 => 'Tidak ada',
                    20 => '≤ 3 fasilitas kreativitas',
                    45 => '4–5 fasilitas kreativitas',
                ],
                'uploads' => [
                ],
            ],
            [
                'judul' => 'Program Sarana & Prasarana Perjalanan Anak Sekolah (Total Nilai 40)',
                'slug' => 'program_perjalanan',
                'nilai' => 40,
                'template_excel' => null,

                'opsi' => [
                    0 => 'Tidak ada',
                    15 => '≤ 3 program',
                    30 => '4–5 program',
                    40 => '8 program',
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

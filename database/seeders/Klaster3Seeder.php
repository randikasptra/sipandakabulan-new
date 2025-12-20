<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Klaster;
use App\Models\IndikatorKlaster;
use App\Models\IndikatorOpsiNilai;
use App\Models\KategoriUpload;

class Klaster3Seeder extends Seeder
{
    public function run(): void
    {
        // Tambah Klaster 3: Kesehatan Dasar dan Kesejahteraan
        $klaster = Klaster::firstOrCreate(
            ['slug' => 'klaster3'],
            [
                'title' => 'Kesehatan Dasar dan Kesejahteraan',
                'nilai_em' => 0,
                'nilai_maksimal' => 160,
                'progres' => 0,
            ]
        );

        // Data indikator klaster 3
        $indikators = [
            [
                'judul' => 'Kematian Bayi AKB (Total Nilai 15)',
                'slug' => 'kematian_bayi',
                'nilai' => 15,
                'template_excel' => 'KematianBayi.xlsx',
                'opsi' => [
                    5 => 'Di bawah 40',
                    15 => 'Di atas 40',
                ],
                'uploads' => [
                ],
            ],
            [
                'judul' => 'Kematian Ibu (Total Nilai 15)',
                'slug' => 'kematian_ibu',
                'nilai' => 15,
                'template_excel' => 'KematianIbu.xlsx',
                'opsi' => [
                    5 => 'Di bawah 40',
                    15 => 'Di atas 40',
                ],
                'uploads' => [
                ],
            ],
            [
                'judul' => 'Prevalensi Kekurangan Gizi pada Balita (Total Nilai 30)',
                'slug' => 'gizi_balita',
                'nilai' => 30,
                'template_excel' => 'GiziBalita.xlsx',
                'opsi' => [
                    10 => '≥ 7',
                    20 => '4 - 7',
                    30 => '≤ 3',
                ],
                'uploads' => [
                ],
            ],
            [
                'judul' => 'ASI Eksklusif (Total Nilai 15)',
                'slug' => 'asi_eksklusif',
                'nilai' => 15,
                'template_excel' => null,
                'opsi' => [
                    0 => 'Tidak ada',
                    15 => 'Ada',
                ],
                'uploads' => [
                ],
            ],
            [
                'judul' => 'Pojok ASI pada Fasilitas Umum Desa (Total Nilai 15)',
                'slug' => 'pojok_asi',
                'nilai' => 15,
                'template_excel' => null,
                'opsi' => [
                    0 => 'Tidak ada',
                    15 => 'Ada',
                ],
                'uploads' => [
                ],
            ],
            [
                'judul' => 'Pusat Kesehatan Reproduksi Remaja (Total Nilai 30)',
                'slug' => 'pusat_kespro',
                'nilai' => 30,
                'template_excel' => null,
                'opsi' => [
                    0 => 'Tidak ada',
                    15 => 'Sedikit',
                    30 => 'Ada',
                ],
                'uploads' => [
                ],
            ],
            [
                'judul' => 'Imunisasi Dasar Lengkap Bagi Anak (Total Nilai 20)',
                'slug' => 'imunisasi_anak',
                'nilai' => 20,
                'template_excel' => null,
                'opsi' => [
                    0 => '≤ 10% dari jumlah anak keluarga miskin',
                    10 => '≤ 25% dari jumlah anak keluarga miskin',
                    20 => '100% dari jumlah anak keluarga miskin',
                ],
                'uploads' => [
                ],
            ],
            [
                'judul' => 'Anak Keluarga Kurang Mampu Dapat Layanan Pengentasan Kemiskinan (Total Nilai 20)',
                'slug' => 'layanan_anak_kurang_mampu',
                'nilai' => 20,
                'template_excel' => null,
                'opsi' => [
                    0 => '≤ 10% dari jumlah anak keluarga Kurang mampu',
                    10 => '≤ 25% dari jumlah anak keluarga Kurang mampu',
                    20 => '100% dari jumlah anak keluarga Kurang mampu',
                ],
                'uploads' => [
                ],
            ],
            [
                'judul' => 'Kawasan Tanpa Rokok (Total Nilai 20)',
                'slug' => 'kawasan_tanpa_rokok',
                'nilai' => 20,
                'template_excel' => null,
                'opsi' => [
                    0 => 'Tidak ada',
                    10 => 'Ada pada kawasan pendidikan dan fasilitas kesehatan',
                    20 => 'Ada pada semua fasilitas layanan umum',
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

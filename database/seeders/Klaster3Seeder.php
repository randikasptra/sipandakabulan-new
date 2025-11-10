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
                'judul' => '1. Kematian Bayi AKB (Total Nilai 30)',
                'slug' => 'kematian_bayi',
                'nilai' => 30,
                'template_excel' => 'KematianBayi.xlsx',
                'opsi' => [
                    0 => 'Di atas rata-rata nasional',
                    15 => 'Sama dengan rata-rata nasional',
                    30 => 'Di bawah rata-rata nasional',
                ],
                'uploads' => [
                    'Penyebab Kematian Bayi',
                    'Umum',
                    'Infeksi',
                    'ISPA',
                    'Tetanus',
                    'Asfixia',
                    'Diare',
                    'Demam Berdarah',
                    'Covid',
                ],
            ],
            [
                'judul' => '2. Prevalensi Kekurangan Gizi pada Balita (Total Nilai 30)',
                'slug' => 'gizi_balita',
                'nilai' => 30,
                'template_excel' => 'GiziBalita.xlsx',
                'opsi' => [
                    0 => 'Di atas rata-rata nasional',
                    15 => 'Sama dengan rata-rata nasional',
                    30 => 'Di bawah rata-rata nasional',
                ],
                'uploads' => [
                    'Prevalensi kekurangan gizi pada balita',
                    'Berapa jumlah anak gizi kurang pada balita?',
                    'Berapa jumlah gizi buruk pada balita?',
                    'Berapa jumlah anak pendek (stunting)?',
                ],
            ],
            [
                'judul' => '3. ASI Eksklusif (Total Nilai 15)',
                'slug' => 'asi_eksklusif',
                'nilai' => 15,
                'template_excel' => null,
                'opsi' => [
                    0 => '0% ≤ 10%',
                    5 => '≥ 25%',
                    10 => '≥ 50%',
                    15 => '100%',
                ],
                'uploads' => [
                    'Dokumen ASI Eksklusif',
                ],
            ],
            [
                'judul' => '4. Pojok ASI pada Fasilitas Umum Desa (Total Nilai 15)',
                'slug' => 'pojok_asi',
                'nilai' => 15,
                'template_excel' => null,
                'opsi' => [
                    0 => 'Tidak ada',
                    10 => 'Sedikit',
                    15 => 'Ada',
                ],
                'uploads' => [
                    'Dokumen Pojok ASI',
                ],
            ],
            [
                'judul' => '5. Pusat Kesehatan Reproduksi Remaja (Total Nilai 30)',
                'slug' => 'pusat_kespro',
                'nilai' => 30,
                'template_excel' => null,
                'opsi' => [
                    0 => 'Tidak ada',
                    15 => 'Sedikit',
                    30 => 'Ada',
                ],
                'uploads' => [
                    'Dokumen Pusat Kesehatan Reproduksi Remaja',
                ],
            ],
            [
                'judul' => '6. Imunisasi Dasar Lengkap Bagi Anak (Total Nilai 20)',
                'slug' => 'imunisasi_anak',
                'nilai' => 20,
                'template_excel' => null,
                'opsi' => [
                    0 => '≤ 10% dari jumlah anak keluarga miskin',
                    10 => '≤ 25% dari jumlah anak keluarga miskin',
                    20 => '100% dari jumlah anak keluarga miskin',
                ],
                'uploads' => [
                    'Dokumen Imunisasi Anak',
                ],
            ],
            [
                'judul' => '7. Anak Keluarga Miskin Dapat Layanan Pengentasan Kemiskinan (Total Nilai 20)',
                'slug' => 'layanan_anak_miskin',
                'nilai' => 20,
                'template_excel' => null,
                'opsi' => [
                    0 => '≤ 10% dari jumlah anak keluarga miskin',
                    10 => '≤ 25% dari jumlah anak keluarga miskin',
                    20 => '100% dari jumlah anak keluarga miskin',
                ],
                'uploads' => [
                    'Dokumen Layanan Anak Keluarga Miskin',
                ],
            ],
            [
                'judul' => '8. Kawasan Tanpa Rokok (Total Nilai 20)',
                'slug' => 'kawasan_tanpa_rokok',
                'nilai' => 20,
                'template_excel' => null,
                'opsi' => [
                    0 => 'Tidak ada',
                    10 => 'Ada pada kawasan pendidikan dan fasilitas kesehatan',
                    20 => 'Ada pada semua fasilitas layanan umum',
                ],
                'uploads' => [
                    'Dokumen Kawasan Tanpa Rokok',
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

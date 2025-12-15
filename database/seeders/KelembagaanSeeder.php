<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Klaster;
use App\Models\IndikatorKlaster;
use App\Models\IndikatorOpsiNilai;
use App\Models\KategoriUpload;

class KelembagaanSeeder extends Seeder
{
    public function run(): void
    {
        // Tambah Klaster Kelembagaan (buat jika belum ada)
        $klaster = Klaster::firstOrCreate(
            ['slug' => 'kelembagaan'],
            [
                'title' => 'Kelembagaan',
                'nilai_em' => 0,
                'nilai_maksimal' => 220, // 60+50+80+50+20
                'progres' => 0,
            ]
        );

        // Data indikator kelembagaan
        $indikators = [
            [
                'judul' => 'Adanya Peraturan yang mencakup lima klaster',
                'slug' => 'peraturan',
                'nilai' => 60,
                'template_excel' => 'peraturan.xlsx',
                'opsi' => [
                    0 => 'Tidak ada',
                    15 => 'Ada 1 SK',
                    30 => 'Ada 2–3 SK',
                    45 => 'Ada 4 SK',
                    60 => 'Ada ≥5 SK'
                ],
                'uploads' => [
                    'SK Gugus Tugas Desa Layak Anak',
                    'SK Bunda Forum Anak Daerah (FAD) Desa',
                    'SK Pusat Pembelajaran Anak Terpadu Berbasis Masyarakat',
                    'SK Satgas Perlindungan Perempuan dan Anak',
                    'SK Forum Anak Desa',
                    'Peraturan tentang kawasan bebas rokok',
                    'SK Sekolah Ramah Anak',
                    'SK Puskesmas Ramah Anak',
                    'Kebijakan pencegahan pernikahan Anak',
                ],
            ],
            [
                'judul' => 'Adanya Anggaran Responsif Anak',
                'slug' => 'anggaran',
                'nilai' => 50,
                'template_excel' => 'anggaran.xlsx',
                'opsi' => [
                    0 => 'Tidak ada',
                    10 => '≤5%',
                    20 => '6–10%',
                    35 => '11–20%',
                    50 => '≥30%'
                ],
                'uploads' => [], // ❌ Tidak ada kategori default, user tambah sendiri
            ],
            [
                'judul' => 'Ada Forum Anak Desa',
                'slug' => 'forum_anak',
                'nilai' => 80,
                'template_excel' => null,
                'opsi' => [
                    0 => 'Tidak ada',
                    80 => 'Ada'
                ],
                'uploads' => [], // ❌ Tidak ada kategori default, user tambah sendiri
            ],
            [
                'judul' => 'Apakah desa sudah memiliki profil desa yang memuat data terpilah',
                'slug' => 'data_terpilah',
                'nilai' => 50,
                'template_excel' => 'data_terpilah.xlsx',
                'opsi' => [
                    0 => 'Tidak ada',
                    50 => 'Ada'
                ],
                'uploads' => [], // ❌ Tidak ada kategori default, user tambah sendiri
            ],
            [
                'judul' => 'Adakah dunia usaha di lingkungan desa yang memiliki keterlibatan dalam pemenuhan hak anak',
                'slug' => 'dunia_usaha',
                'nilai' => 20,
                'template_excel' => 'dunia_usaha.xlsx',
                'opsi' => [
                    0 => 'Tidak ada',
                    10 => '1–2 usaha',
                    15 => '3 usaha',
                    20 => '≥4 usaha'
                ],
                'uploads' => [], // ❌ Tidak ada kategori default, user tambah sendiri
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

            // Simpan opsi nilai
            foreach ($indikatorData['opsi'] as $poin => $label) {
                IndikatorOpsiNilai::create([
                    'indikator_id' => $indikator->id,
                    'label' => $label,
                    'poin' => $poin,
                ]);
            }

            // Simpan kategori upload (hanya jika ada)
            if (!empty($indikatorData['uploads'])) {
                foreach ($indikatorData['uploads'] as $uploadName) {
                    KategoriUpload::create([
                        'indikator_id' => $indikator->id,
                        'nama_kategori' => $uploadName,
                        'is_custom' => false, // ✅ Kategori default dari seeder
                        'desa_id' => null,    // ✅ Null karena ini kategori global
                    ]);
                }
            }
        }
    }
}
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
                'nilai_maksimal' => 220, // 60+50+40+50+20
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
                'uploads' => [
                    'Penguatan Kelembagaan',
                    'Hak Sipil dan Kebebasan',
                    'Lingkungan Keluarga dan Pengasuhan Alternatif',
                    'Kesehatan Dasar dan Kesejahteraan',
                    'Pendidikan, Pemanfaatan Waktu Luang dan Kegiatan Budaya',
                    'Perlindungan Khusus',
                ],
            ],
            [
                'judul' => 'Ada Forum Anak Desa',
                'slug' => 'forum_anak',
                'nilai' => 40,
                'template_excel' => null,
                'opsi' => [
                    0 => 'Tidak ada',
                    13 => 'Ada tapi tidak aktif',
                    26 => 'Ada, aktif sesekali',
                    40 => 'Ada dan aktif rutin'
                ],
                'uploads' => [
                    'Dokumen Forum Anak Desa',
                ],
            ],
            [
                'judul' => 'Ada Data Terpilah mencakup 5 klaster',
                'slug' => 'data_terpilah',
                'nilai' => 50,
                'template_excel' => 'data_terpilah.xlsx',
                'opsi' => [
                    0 => 'Tidak ada',
                    15 => '1 Klaster',
                    30 => '2–3 Klaster',
                    40 => '4 Klaster',
                    50 => '5 Klaster'
                ],
                'uploads' => [
                    'Jumlah Anak berumur 0 - 18 tahun',
                    'Jumlah Anak Yang Memiliki Akta Kelahiran',
                    'Jumlah Anak Yang Memiliki KIA',
                    'Jumlah Anak yang Tidak Memiliki Akta Kelahiran',
                    'Jumlah Anak Yang Tidak Memiliki KIA',
                    'Jumlah Anak Yang Bersekolah',
                    'Jumlah Anak Putus Sekolah',
                    'Jumlah Anak Yang Bekerja',
                    'Jumlah Anak Yang Menikah dibawah 18 tahun',
                    'Jumlah Anak Yang Stunting',
                    'Jumlah Anak Yang kelebihan gizi (obesitas)',
                    'Jumlah Anak penderita Gizi Buruk',
                    'Jumlah Anak bersekolah SD/MI/SLB',
                    'Jumlah Anak bersekolah SMP/MTs/SMPLB',
                    'Jumlah Anak bersekolah SMA/MA/SMALB',
                    'Jumlah Anak Korban Kekerasan',
                    'Jumlah Kasus Anak Berhadapan Dengan Hukum',
                    'Jumlah Anak Yang diadopsi',
                    'Jumlah anak yang diasuh oleh keluarga lain',
                    'Jumlah anak yang mengikuti Kejar Paket',
                    'Jumlah anak Keluarga Miskin yang mendapatkan layanan program pengentasan kemiskinan',
                ],
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
                'uploads' => [
                    'Dokumen Dunia Usaha Peduli Anak',
                ],
            ],
        ];

        foreach ($indikators as $indikatorData) {
            $indikator = IndikatorKlaster::create([
                'klaster_id' => $klaster->id,
                'nama_indikator' => $indikatorData['judul'], // ✅ Ubah dari 'nama'
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

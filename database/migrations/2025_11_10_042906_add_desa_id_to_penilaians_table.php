<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('penilaians', function (Blueprint $table) {
            // ✅ Tambahkan kolom desa_id (jika belum ada)
            if (!Schema::hasColumn('penilaians', 'desa_id')) {
                $table->foreignId('desa_id')
                    ->nullable()
                    ->after('user_id')
                    ->constrained('desas')
                    ->onDelete('set null');
            }

            // ✅ Tambahkan unique constraint baru
            // (tanpa hapus constraint lama, biar gak error)
            if (!Schema::hasColumn('penilaians', 'indikator_id')) {
                // just in case future compatibility
                return;
            }

            $table->unique(
                ['desa_id', 'klaster_id', 'indikator_id', 'tahun'],
                'unique_penilaian_per_desa_klaster_tahun'
            );
        });
    }

    public function down(): void
    {
        Schema::table('penilaians', function (Blueprint $table) {
            // Drop dengan aman (pakai try-catch supaya gak error)
            try {
                $table->dropUnique('unique_penilaian_per_desa_klaster_tahun');
            } catch (\Throwable $th) {
                // skip jika belum ada
            }

            if (Schema::hasColumn('penilaians', 'desa_id')) {
                $table->dropForeign(['desa_id']);
                $table->dropColumn('desa_id');
            }
        });
    }
};

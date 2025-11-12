<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('indikator_klaster', function (Blueprint $table) {
            $table->string('template_excel')->nullable(); // Hapus ->after('total_nilai')
        });
    }

    public function down(): void
    {
        Schema::table('indikator_klaster', function (Blueprint $table) {
            $table->dropColumn('template_excel');
        });
    }
};

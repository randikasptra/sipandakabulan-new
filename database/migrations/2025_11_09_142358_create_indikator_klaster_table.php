<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('indikator_klaster', function (Blueprint $table) {
            $table->id();
            $table->foreignId('klaster_id')->constrained('klasters')->onDelete('cascade');
            $table->string('nama_indikator'); // ✅ ubah dari 'nama'
            $table->string('slug'); // ✅ tambahkan ini
            $table->text('deskripsi')->nullable();
            $table->integer('total_nilai')->default(0); // ✅ ubah dari 'bobot'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indikator_klaster');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('klasters', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Contoh: Klaster I: Hak Sipil dan Kebebasan
            $table->string('kode')->unique(); // klaster1, klaster2, dst
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('klasters');
    }
};

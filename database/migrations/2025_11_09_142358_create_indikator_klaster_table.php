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
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->integer('bobot')->default(0); // optional, misal nilai max per indikator
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indikator_klaster');
    }
};

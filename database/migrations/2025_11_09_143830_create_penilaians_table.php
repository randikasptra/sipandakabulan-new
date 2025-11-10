<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('klaster_id')->constrained('klasters')->onDelete('cascade');
            $table->foreignId('indikator_id')->constrained('indikator_klaster')->onDelete('cascade');
            $table->integer('nilai')->nullable();
            $table->year('tahun');
            $table->string('bulan', 20);
            $table->integer('total_nilai')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};

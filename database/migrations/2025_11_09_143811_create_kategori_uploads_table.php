<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('kategori_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('indikator_id')->constrained('indikator_klaster')->onDelete('cascade');
            $table->string('nama'); // contoh: "KUA", "0–60 hari", "Posyandu HI"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_uploads');
    }
};

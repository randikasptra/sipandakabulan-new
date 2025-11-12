<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('berkas_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penilaian_id')->constrained('penilaians')->onDelete('cascade');
            $table->foreignId('kategori_upload_id')->constrained('kategori_uploads')->onDelete('cascade');
            $table->string('path_file')->nullable();
            $table->integer('nilai')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berkas_uploads');
    }
};

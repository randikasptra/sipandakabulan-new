<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('desas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_desa');
            $table->string('kode_desa')->nullable(); // optional untuk kode unik
            $table->string('alamat_kantor')->nullable();
            $table->string('nama_kades')->nullable(); // nama kepala desa
            $table->string('no_telp')->nullable();
            $table->timestamps();
        });

        // update relasi di tabel users (biar user desa bisa punya desa_id)
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('desa_id')->references('id')->on('desas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['desa_id']);
        });

        Schema::dropIfExists('desas');
    }
};

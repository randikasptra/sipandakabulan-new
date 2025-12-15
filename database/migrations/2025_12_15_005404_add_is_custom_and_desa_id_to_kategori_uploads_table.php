<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kategori_uploads', function (Blueprint $table) {
            $table->boolean('is_custom')->default(false)->after('nama_kategori');
            $table->foreignId('desa_id')->nullable()->after('is_custom')->constrained('desas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('kategori_uploads', function (Blueprint $table) {
            $table->dropColumn(['is_custom', 'desa_id']);
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('klasters', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // contoh: Hak Sipil dan Kebebasan
            $table->string('slug')->unique(); // contoh: klaster1
            $table->integer('nilai_em')->default(0);
            $table->integer('nilai_maksimal')->default(0);
            $table->integer('progres')->default(0);
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('klasters');
    }
};

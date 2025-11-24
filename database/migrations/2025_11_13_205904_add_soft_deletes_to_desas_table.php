<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('desas', function (Blueprint $table) {
            if (!Schema::hasColumn('desas', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('desas');
    }
};

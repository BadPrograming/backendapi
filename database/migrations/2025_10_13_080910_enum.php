<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('admin', function (Blueprint $table) {
            // ubah kolom role menjadi enum
            $table->enum('role', ['admin', 'super_admin'])->default('admin')->change();
        });
    }

    public function down(): void
    {
        Schema::table('admin', function (Blueprint $table) {
            // kembalikan menjadi string jika rollback
            $table->string('role')->default('admin')->change();
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah slug di category_service
        Schema::table('category_service', function (Blueprint $table) {
            $table->string('slug')->unique()->after('title');
        });

        // Tambah slug di category_career
        Schema::table('category_career', function (Blueprint $table) {
            $table->string('slug')->unique()->after('title');
        });
    }

    public function down(): void
    {
        Schema::table('category_service', function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        Schema::table('category_career', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
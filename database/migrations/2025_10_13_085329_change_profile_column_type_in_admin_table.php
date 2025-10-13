<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('team', function (Blueprint $table) {
            $table->string('profile')->nullable()->change(); // ubah text -> string
        });
    }

    public function down(): void
    {
        Schema::table('team', function (Blueprint $table) {
            $table->text('profile')->change(); // rollback ke text
        });
    }
};
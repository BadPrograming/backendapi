<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team', function (Blueprint $table) {
            $table->id(); // id
            $table->string('name'); // nama anggota
            $table->text('profile'); // profil / deskripsi
            $table->string('role'); // peran di tim
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team');
    }
};
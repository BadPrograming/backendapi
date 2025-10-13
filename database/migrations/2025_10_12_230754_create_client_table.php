<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // nama client
            $table->string('images')->nullable(); // path gambar/logo client
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client');
    }
};
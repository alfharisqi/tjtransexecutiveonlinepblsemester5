<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('trains', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('class');
            $table->string('nopol'); // kolom nomor polisi
            $table->string('foto')->nullable(); // kolom foto, bisa null kalau belum ada
            
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('trains');
    }
};

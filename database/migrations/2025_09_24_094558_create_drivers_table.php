<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_driver');
            $table->string('username')->unique();
            $table->string('password');          // password akan di-hash
            $table->string('email')->unique();
            $table->string('no_telepon')->nullable();
            $table->string('sim')->nullable();   // nomor SIM
            $table->string('foto')->nullable();  // path foto profil
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};

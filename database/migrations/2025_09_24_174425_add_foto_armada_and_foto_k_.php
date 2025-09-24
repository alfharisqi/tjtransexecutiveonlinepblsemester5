<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trains', function (Blueprint $table) {
            // path file di storage (mis. storage/app/public/trains/xxx.jpg)
            $table->string('foto_armada')->nullable();
            $table->string('foto_kursi')->nullable();
            // Jika ingin menentukan posisi kolom, bisa pakai ->after('nama_kolom_sebelumnya')
            // dan sesuaikan dengan skema Anda. Contoh:
            // $table->string('foto_armada')->nullable()->after('class');
            // $table->string('foto_kursi')->nullable()->after('foto_armada');
        });
    }

    public function down(): void
    {
        Schema::table('trains', function (Blueprint $table) {
            $table->dropColumn(['foto_armada', 'foto_kursi']);
        });
    }
};

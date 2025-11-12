<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expense_presets', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama biaya, contoh: BBM, Tol, Makan Sopir
            $table->string('vehicle_type')->nullable(); // Opsional: tipe kendaraan (Hiace, Innova)
            $table->bigInteger('amount')->default(0); // Nilai default biaya
            $table->boolean('is_active')->default(true); // Aktif/tidak
            $table->integer('amortization_cycles')->nullable(); // Jika biaya dibagi per trip
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expense_presets');
    }
};

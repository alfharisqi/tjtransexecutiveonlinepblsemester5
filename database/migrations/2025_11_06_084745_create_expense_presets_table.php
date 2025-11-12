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
            $table->string('name');                      // Nama preset (misal: Driver, Bensin)
            $table->string('vehicle_type')->nullable();  // Jenis kendaraan (opsional)
            $table->unsignedBigInteger('amount');        // Nominal default
            $table->boolean('is_active')->default(true); // Aktif/tidak
            $table->unsignedInteger('amortization_cycles')->nullable(); // Opsional
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expense_presets');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('trip_settlements', function (Blueprint $t) {
            $t->id();
            $t->date('date');                                // tanggal rekap
            $t->unsignedBigInteger('track_id')->nullable();  // opsional
            $t->unsignedBigInteger('driver_id')->nullable(); // opsional
            $t->unsignedBigInteger('ticket_id')->nullable(); // kita pakai per tiket
            $t->string('vehicle_type')->nullable();          // 'innova'/'hiace'/dll
            $t->string('status')->default('draft');          // draft|pending_approval|approved

            // hasil perhitungan
            $t->unsignedBigInteger('income_gross')->default(0);
            $t->unsignedBigInteger('expense_total')->default(0);
            $t->unsignedBigInteger('income_net')->default(0);

            // approval
            $t->unsignedBigInteger('approved_by')->nullable();
            $t->timestamp('approved_at')->nullable();

            $t->timestamps();

            $t->index(['date']);
            $t->index(['ticket_id']);
            $t->index(['status']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('trip_settlements');
    }
};

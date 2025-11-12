<?php
// database/migrations/2025_11_05_000000_create_expenses_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->date('date');                 // tanggal biaya
            $table->string('category')->nullable(); // contoh: BBM, gaji, maintenance, dll
            $table->unsignedBigInteger('amount'); // dalam rupiah (integer)
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('expenses'); }
};


<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_status_perjalanan_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('status_perjalanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->enum('status', ['belum_dijemput', 'perjalanan', 'tiba_ditujuan'])->default('belum_dijemput');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('status_perjalanan');
    }
};

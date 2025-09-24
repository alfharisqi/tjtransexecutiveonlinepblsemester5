<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('passengers', function (Blueprint $table) {
            if (!Schema::hasColumn('passengers', 'umur_penumpang')) {
                // taruh di akhir tabel (aman di semua skema)
                $table->unsignedTinyInteger('umur_penumpang')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('passengers', function (Blueprint $table) {
            if (Schema::hasColumn('passengers', 'umur_penumpang')) {
                $table->dropColumn('umur_penumpang');
            }
        });
    }
};

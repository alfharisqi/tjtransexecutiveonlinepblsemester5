<?php
// database/migrations/xxxx_xx_xx_xxxxxx_drop_old_time_columns_from_tickets.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (Schema::hasColumn('tickets', 'departure_time')) $table->dropColumn('departure_time');
            if (Schema::hasColumn('tickets', 'arrival_time'))   $table->dropColumn('arrival_time');
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->time('departure_time')->nullable();
            $table->time('arrival_time')->nullable();
        });
    }
};

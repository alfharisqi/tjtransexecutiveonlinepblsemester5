<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddUniqueToOrderSeats extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('order_seats')) {
            return;
        }

        // Bersihkan duplikat agar unique index bisa dibuat
        $dups = DB::table('order_seats')
            ->select('ticket_id', 'go_date', 'seat_code', DB::raw('COUNT(*) as c'))
            ->groupBy('ticket_id', 'go_date', 'seat_code')
            ->having('c', '>', 1)
            ->get();

        foreach ($dups as $d) {
            $ids = DB::table('order_seats')
                ->where('ticket_id', $d->ticket_id)
                ->where('go_date', $d->go_date)
                ->where('seat_code', $d->seat_code)
                ->orderBy('id') // sisakan yang terkecil
                ->pluck('id')->toArray();

            if (count($ids) > 1) {
                DB::table('order_seats')->whereIn('id', array_slice($ids, 1))->delete();
            }
        }

        // Tambahkan unique index jika belum ada
        if (!$this->indexExists('order_seats', 'order_seats_ticket_date_seat_unique')) {
            Schema::table('order_seats', function (Blueprint $table) {
                $table->unique(['ticket_id', 'go_date', 'seat_code'], 'order_seats_ticket_date_seat_unique');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('order_seats')) {
            return;
        }

        if ($this->indexExists('order_seats', 'order_seats_ticket_date_seat_unique')) {
            Schema::table('order_seats', function (Blueprint $table) {
                $table->dropUnique('order_seats_ticket_date_seat_unique');
            });
        }
    }

    private function indexExists(string $table, string $indexName): bool
    {
        $db = DB::getDatabaseName();
        return DB::table('information_schema.STATISTICS')
            ->where('TABLE_SCHEMA', $db)
            ->where('TABLE_NAME', $table)
            ->where('INDEX_NAME', $indexName)
            ->exists();
    }
}

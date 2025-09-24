<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $orders = DB::table('orders')
            ->select('id','ticket_id','go_date','selected_seats')
            ->whereNotNull('selected_seats')
            ->get();

        foreach ($orders as $o) {
            $seats = array_filter(array_map('trim', explode(',', $o->selected_seats)));
            foreach ($seats as $s) {
                // insert ignore untuk abaikan konflik duplikat
                DB::statement("
                    INSERT IGNORE INTO order_seats (order_id, ticket_id, go_date, seat_code, created_at, updated_at)
                    VALUES (?, ?, ?, ?, NOW(), NOW())
                ", [$o->id, $o->ticket_id, $o->go_date, $s]);
            }
        }
    }

    public function down(): void
    {
        // Tidak perlu rollback khusus
    }
};

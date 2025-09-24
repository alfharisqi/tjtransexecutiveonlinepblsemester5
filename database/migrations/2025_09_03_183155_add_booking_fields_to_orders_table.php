<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Tambah index untuk pencarian jadwal
            if (!Schema::hasColumn('orders', 'order_code')) {
                $table->string('order_code')->after('user_id');
            }
            // Kapasitas & info pemesan
            $table->string('alamat_lengkap')->nullable()->after('amount');
            $table->string('nowhatsapp', 30)->nullable()->after('alamat_lengkap');

            // Kursi (CSV) -> sementara/opsional jika belum pakai tabel order_seats
            $table->string('selected_seats', 64)->nullable()->after('amount');

            // Pembayaran
            $table->foreignId('method_id')->nullable()->after('selected_seats'); // akan dikunci di bawah
            $table->string('name_account', 100)->nullable()->after('method_id');
            $table->string('from_account', 100)->nullable()->after('name_account');

            // Status order
            $table->enum('status', ['pending','paid','cancelled'])->default('pending')->after('from_account');

            // Index & FK
            $table->unique('order_code');
            $table->index(['ticket_id','go_date']);
        });

        // Tambah foreign keys terpisah agar aman jika sebelumnya belum constrained
        Schema::table('orders', function (Blueprint $table) {
            if (!collect($table->getColumns() ?? [])->contains('user_id')) {
                // abaikan, hanya ilustrasi; biasanya sudah ada
            }
        });

        // Tambah FK user, ticket, method (gunakan try-catch untuk berjaga jika sudah ada)
        try {
            Schema::table('orders', function (Blueprint $table) {
                // Jika sebelumnya belum pakai constrained():
                $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
                $table->foreign('ticket_id')->references('id')->on('tickets')->cascadeOnDelete();
                $table->foreign('method_id')->references('id')->on('methods')->nullOnDelete();
            });
        } catch (\Throwable $e) {
            // Jika FK sudah ada, abaikan
        }

        // CHECK constraint amount 1..11 (aktif hanya MySQL 8+)
        try {
            DB::statement('ALTER TABLE orders ADD CONSTRAINT chk_orders_amount CHECK (amount BETWEEN 1 AND 11)');
        } catch (\Throwable $e) {
            // Jika MySQL lama / constraint sudah ada -> abaikan
        }
    }

    public function down(): void
    {
        // Lepas CHECK (MySQL butuh nama persis)
        try {
            DB::statement('ALTER TABLE orders DROP CONSTRAINT chk_orders_amount');
        } catch (\Throwable $e) {}

        Schema::table('orders', function (Blueprint $table) {
            // Hapus kolom-kolom yang ditambahkan
            if (Schema::hasColumn('orders', 'status')) $table->dropColumn('status');
            if (Schema::hasColumn('orders', 'from_account')) $table->dropColumn('from_account');
            if (Schema::hasColumn('orders', 'name_account')) $table->dropColumn('name_account');
            if (Schema::hasColumn('orders', 'method_id')) $table->dropForeign(['method_id']);
            if (Schema::hasColumn('orders', 'method_id')) $table->dropColumn('method_id');
            if (Schema::hasColumn('orders', 'selected_seats')) $table->dropColumn('selected_seats');
            if (Schema::hasColumn('orders', 'nowhatsapp')) $table->dropColumn('nowhatsapp');
            if (Schema::hasColumn('orders', 'alamat_lengkap')) $table->dropColumn('alamat_lengkap');

            // Hapus index tambahan
            try { $table->dropUnique(['order_code']); } catch (\Throwable $e) {}
            try { $table->dropIndex(['ticket_id','go_date']); } catch (\Throwable $e) {}
        });
    }
};

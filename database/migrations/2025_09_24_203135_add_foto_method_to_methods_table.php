<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('methods', function (Blueprint $table) {
            $table->string('foto_method')->nullable()->after('target_account');
        });
    }

    public function down(): void
    {
        Schema::table('methods', function (Blueprint $table) {
            $table->dropColumn('foto_method');
        });
    }
};

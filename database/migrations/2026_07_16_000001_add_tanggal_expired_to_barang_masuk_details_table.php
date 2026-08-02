<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('barang_masuk_details', function (Blueprint $table) {
            $table->date('tanggal_expired')->nullable()->after('total_harga');
        });
    }

    public function down(): void
    {
        Schema::table('barang_masuk_details', function (Blueprint $table) {
            $table->dropColumn('tanggal_expired');
        });
    }
};

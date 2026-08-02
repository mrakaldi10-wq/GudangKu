<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('barang_pendings', function (Blueprint $table) {
            $table->dropForeign(['pemasok_id']);
            $table->dropColumn('pemasok_id');
        });

        Schema::table('barang_pendings', function (Blueprint $table) {
            $table->foreignId('pelanggan_id')->nullable()->after('no_transaksi')
                ->constrained('pelanggans')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('barang_pendings', function (Blueprint $table) {
            $table->dropForeign(['pelanggan_id']);
            $table->dropColumn('pelanggan_id');
        });

        Schema::table('barang_pendings', function (Blueprint $table) {
            $table->foreignId('pemasok_id')->nullable()->after('no_transaksi')
                ->constrained('pemasoks')->nullOnDelete();
        });
    }
};

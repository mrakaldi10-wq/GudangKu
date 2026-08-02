<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('barang_pendings', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_pending');
            $table->string('no_transaksi')->unique();
            $table->foreignId('pemasok_id')->nullable()->constrained('pemasoks')->nullOnDelete();
            $table->integer('total_qty')->default(0);
            $table->integer('total_harga')->default(0);
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_pendings');
    }
};

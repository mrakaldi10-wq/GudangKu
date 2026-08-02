<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->foreignId('volume_id')->nullable()->after('satuan_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropForeign(['volume_id']);
            $table->dropColumn('volume_id');
        });
    }
};

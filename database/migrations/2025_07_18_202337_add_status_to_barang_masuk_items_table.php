<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('barang_masuk_items', function (Blueprint $table) {
            //
            $table->integer('status')->default(0)->after('tgl_expired')->comment('Status Barang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barang_masuk_items', function (Blueprint $table) {
            //
            $table->dropColumn('status');
        });
    }
};

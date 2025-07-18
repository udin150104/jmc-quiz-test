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
        Schema::create('kategori', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->comment("kode kategori");
            $table->string('nama')->comment("nama kategori");
            $table->timestamps();
        });
        Schema::create('sub_kategori', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade');
            $table->string('nama')->comment("nama sub kategori");
            $table->decimal('limit_price', 65, 0)->comment('Batas harga dalam rupiah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_kategori');
        Schema::dropIfExists('kategori');
    }
};

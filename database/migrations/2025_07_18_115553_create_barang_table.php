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
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->comment("Operator");
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade');
            $table->foreignId('sub_kategori_id')->constrained('sub_kategori')->onDelete('cascade');
            $table->string('suplier')->comment("Asal Barang");
            $table->string('no_surat')->comment("No Surat")->nullable();
            $table->text('lampiran')->comment(comment: "lampiran")->nullable();
            $table->timestamps();
        });


        Schema::create('barang_masuk_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_masuk_id')->constrained('barang_masuk')->onDelete('cascade');
            $table->string('nama')->comment("Nama Barang");
            $table->decimal('price', 65, 0)->comment(comment: "Harga Barang");
            $table->integer('qty')->comment(comment: "Jumlah Barang");
            $table->string('satuan')->comment(comment: "Satuan Barang");
            $table->decimal('total', 65, 0)->comment(comment: "Harga Total Barang");
            $table->date('tgl_expired')->comment(comment: "Satuan Barang")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuk_items');
        Schema::dropIfExists('barang_masuk');
    }
};

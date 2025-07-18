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
        Schema::create('penduduk', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->comment("nama");
            $table->string('nik')->comment("nik");
            $table->date('tanggal_lahir')->comment("Tanggal Lahir");
            $table->enum('jenis_kelamin',['P','L'])->comment("Jenis Kelamin L = laki-laki , P = perempuan");
            $table->foreignId('provinsi_id')->constrained('provinsi')->onDelete('cascade');
            $table->foreignId('kabupaten_id')->constrained('kabupaten')->onDelete('cascade');
            $table->text('alamat')->comment("alamat");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penduduk');
    }
};

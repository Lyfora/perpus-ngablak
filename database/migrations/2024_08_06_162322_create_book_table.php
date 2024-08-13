<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('volume');
            $table->string('penerbit');
            $table->string('status_code')->default('tersedia');
            $table->string('nama_peminjam')->nullable();
            $table->string('thumbnail');
            $table->timestampsTz();
            $table->year('tahun_buku');
            $table->string('lokasi')->nullable();
            $table->foreignId('kategori')->contsrained();
            $table->foreignId('pengarang')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bukus');
    }
};

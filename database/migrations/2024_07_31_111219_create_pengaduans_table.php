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
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id');
            $table->foreignId('masalah_id');
            $table->foreignId('warga_id');
            $table->string('kode');
            $table->string('judul');
            $table->string('lokasi');
            $table->longText('isi_pengaduan');
            $table->date('tgl_pengaduan');
            $table->string('statuspengaduan');
            $table->string('foto_pengaduan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};

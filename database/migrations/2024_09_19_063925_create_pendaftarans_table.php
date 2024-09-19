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
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eskul_id');
            $table->foreignId('siswa_id');
            $table->foreignId('jurusan_id');
            $table->foreignId('kelas_id');
            $table->string('nis');
            $table->string('nama');
            $table->string('tmp_lahir');
            $table->string('tgl_lahir');
            $table->string('jk');
            $table->string('telp');
            $table->string('email');
            $table->string('status');
            $table->text('alasan');
            $table->text('alamat');
            $table->string('berkas_pendaftaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};

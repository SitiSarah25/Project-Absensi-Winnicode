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
        Schema::create('presensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke tabel users
            $table->date('tanggal_presensi');
            $table->time('jam_masuk');
            $table->time('jam_keluar')->nullable(); // Jam keluar bisa jadi null jika baru absen masuk
            $table->text('lokasi_masuk')->nullable(); // Format JSON: {"latitude": xxx, "longitude": xxx}
            $table->text('lokasi_keluar')->nullable(); // Format JSON: {"latitude": xxx, "longitude": xxx}
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presensi');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tbl_layanan', function (Blueprint $table) {
            $table->string('id_layanan', 6)->primary();
            $table->string('nama_layanan', 100);
            $table->text('deskripsi')->nullable();
            $table->decimal('harga_per_kg', 10, 2);
            $table->integer('estimasi_durasi');
            $table->enum('status_layanan', ['aktif', 't_aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_layanan');
    }
};
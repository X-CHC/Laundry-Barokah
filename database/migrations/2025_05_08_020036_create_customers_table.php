<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id('id_customer');
            $table->string('username', 50);
            $table->string('password', 255);
            $table->string('email', 100);
            $table->string('nama_panjang', 100);
            $table->string('tlp', 20);
            $table->text('alamat')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            // $table->id();
            $table->uuid('id')->primary();
            $table->string('no_reference');
            $table->string('plat_nomor');
            $table->string('warna');
            $table->string('merk');
            $table->string('model');
            $table->string('tahun',4);
            $table->string('no_rangka');
            $table->string('transmisi');
            $table->text('foto_kendaraan');
            $table->text('foto_stnk');
            $table->text('foto_sisi_depan');
            $table->text('foto_sisi_belakang');
            $table->text('foto_sisi_kanan');
            $table->text('foto_sisi_kiri');
            $table->text('foto_sisi_interior');
            $table->string('status');
            // $table->text('foto_full_body');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}

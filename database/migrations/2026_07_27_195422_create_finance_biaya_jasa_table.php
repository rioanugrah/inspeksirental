<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceBiayaJasaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_biaya_jasa', function (Blueprint $table) {
            $table->id();
            $table->uuid('cars_id');
            $table->string('customer');
            $table->string('lokasi');
            $table->double('biaya_jasa')->nullable();
            $table->double('biaya_transport')->nullable();
            $table->double('biaya_gaji_karyawan')->nullable();
            // $table->decimal('total',10,2);
            $table->string('inspector')->nullable();
            $table->string('pembayaran')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('status')->default('Waiting');
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
        Schema::dropIfExists('finance_biaya_jasa');
    }
}

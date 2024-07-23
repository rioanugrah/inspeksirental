<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspeksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspeksi_bagian_depan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('cars_id');
            $table->string('kaca_depan',50);
            $table->text('foto_kaca_depan')->nullable();
            $table->string('kap_mesin',50);
            $table->text('foto_kap_mesin')->nullable();
            $table->string('rangka_mobil',50);
            $table->text('foto_rangka_mobil')->nullable();
            $table->string('aki',50);
            $table->text('foto_aki')->nullable();
            $table->string('radiator',50);
            $table->text('foto_radiator')->nullable();
            $table->string('kondisi_mesin',50);
            $table->text('foto_kondisi_mesin')->nullable();
            $table->string('bumper_lampu',50);
            $table->text('foto_bumper_lampu')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('inspeksi_bagian_kiri', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('cars_id');
            $table->string('fender_depan_kiri',50);
            $table->text('foto_fender_depan_kiri')->nullable();
            $table->string('kaki_depan_kiri',50);
            $table->text('foto_kaki_depan_kiri')->nullable();
            $table->string('kaki_belakang_kiri',50);
            $table->text('foto_kaki_belakang_kiri')->nullable();
            $table->string('pintu_depan_kiri',50);
            $table->text('foto_pintu_depan_kiri')->nullable();
            $table->string('pintu_belakang_kiri',50);
            $table->text('foto_pintu_belakang_kiri')->nullable();
            $table->string('fender_belakang_kiri',50);
            $table->text('foto_fender_belakang_kiri')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('inspeksi_bagian_belakang', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('cars_id');
            $table->string('lampu_belakang',50);
            $table->text('foto_lampu_belakang')->nullable();
            $table->string('pintu_bagasi_belakang',50);
            $table->text('foto_pintu_bagasi_belakang')->nullable();
            $table->string('bumper_belakang',50);
            $table->text('foto_bumper_belakang')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('inspeksi_bagian_kanan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('cars_id');
            $table->string('fender_depan_kanan',50);
            $table->text('foto_fender_depan_kanan')->nullable();
            $table->string('kaki_depan_kanan',50);
            $table->text('foto_kaki_depan_kanan')->nullable();
            $table->string('kaki_belakang_kanan',50);
            $table->text('foto_kaki_belakang_kanan')->nullable();
            $table->string('pintu_depan_kanan',50);
            $table->text('foto_pintu_depan_kanan')->nullable();
            $table->string('pintu_belakang_kanan',50);
            $table->text('foto_pintu_belakang_kanan')->nullable();
            $table->string('fender_belakang_kanan',50);
            $table->text('foto_fender_belakang_kanan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('inspeksi_interior', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('cars_id');
            $table->text('foto_speedometer')->nullable();
            $table->text('keterangan_speedometer')->nullable();
            $table->text('foto_setir')->nullable();
            $table->text('keterangan_setir')->nullable();
            $table->text('foto_dasboard')->nullable();
            $table->text('keterangan_dasboard')->nullable();
            $table->text('foto_plafon')->nullable();
            $table->text('keterangan_plafon')->nullable();
            $table->text('foto_ac')->nullable();
            $table->text('keterangan_ac')->nullable();
            $table->text('foto_audio')->nullable();
            $table->text('keterangan_audio')->nullable();
            $table->text('foto_jok')->nullable();
            $table->text('keterangan_jok')->nullable();
            $table->text('foto_electric_spion')->nullable();
            $table->text('keterangan_electric_spion')->nullable();
            $table->text('foto_power_window')->nullable();
            $table->text('keterangan_power_window')->nullable();
            $table->text('foto_lain_lain')->nullable();
            $table->text('keterangan_lain_lain')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Schema::create('inspeksi_lain', function (Blueprint $table) {
        //     $table->uuid('id')->primary();
        //     $table->uuid('cars_id');
        //     $table->text('foto_lain_lain')->nullable();
        //     $table->text('keterangan_lain_lain')->nullable();
        //     $table->timestamps();
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inspeksi_bagian_depan');
        Schema::dropIfExists('inspeksi_bagian_kiri');
        Schema::dropIfExists('inspeksi_bagian_belakang');
        Schema::dropIfExists('inspeksi_bagian_kanan');
        Schema::dropIfExists('inspeksi_interior');
        // Schema::dropIfExists('inspeksi_lain');
    }
}

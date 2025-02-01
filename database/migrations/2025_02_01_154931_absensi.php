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
        Schema::create('absen', function (Blueprint $table) {
            $table->bigIncrements('idabsen');
            $table->String('idsiswa');
            $table->date('tanggal');
            $table->String('jammasuk');
            $table->String('jamkeluar');
            $table->timestamps();
        });

        Schema::create('keterangan', function (Blueprint $table) {
            $table->bigIncrements('idketerangan');
            $table->enum('keterangan', ["S", "I", "A", "H"])->uniqid();
            $table->timestamps();
        });

        Schema::create('bacakartu', function (Blueprint $table) {
            $table->bigIncrements('idbacakartu');
            $table->String('uuid')->nullable();
            $table->String('kodealat');
            $table->Integer('idsekolah')->nullable();
            $table->timestamps();
        });

        Schema::create('alatabsensi', function (Blueprint $table) {
            $table->bigIncrements('idalatabsensi');
            $table->String('idinstansi');
            $table->enum('fungsi', ["absensi","pengelola"]);
            $table->String('kodealat')->uniqid();
            $table->String('timestamp');
            $table->String('pascode');
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
        //
    }
};

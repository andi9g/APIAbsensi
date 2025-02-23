<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->char('nisn', 13);
            $table->date('tanggal');
            $table->String('jammasuk')->nullable();
            $table->String('jamkeluar')->nullable();
            $table->timestamps();
        });

        Schema::create('keterangan', function (Blueprint $table) {
            $table->bigIncrements('idketerangan');
            $table->Integer('idinstansi');
            $table->enum('keterangan', ["S", "I", "A", "H"])->uniqid();
            $table->timestamps();
        });

        $keterangan = ["S", "I", "A", "H"];
        foreach ($keterangan as $h) {
            DB::connection("mysql")->table("keterangan")->insert([
                "idinstansi" => 1,
                "keterangan" => $h,
            ]);
        }

        Schema::create('bacakartu', function (Blueprint $table) {
            $table->bigIncrements('idbacakartu');
            $table->String('uuid')->nullable();
            $table->String('kodealat');
            $table->Integer('idinstansi');
            $table->timestamps();
        });



        Schema::create('alatabsensi', function (Blueprint $table) {
            $table->bigIncrements('idalatabsensi');
            $table->Integer('idinstansi');
            $table->enum('fungsi', ["absensi","pengelola"]);
            $table->String('kodealat')->uniqid();
            $table->String('timestamp');
            $table->String('pascode');
            $table->timestamps();
        });

        DB::connection("mysql")->table("alatabsensi")->insert([
            "idinstansi" => "1",
            "fungsi" => "pengelola",
            "kodealat" => "67b866a10589b",
            "timestamp" => "1740138145",
            "pascode" => '$2y$10$p5Kur5Vv/WWfgmEIMFBlX.hj6tDIsk4BwglUVu7lxHYhkBdODsqEi'
        ]);

        Schema::create('kelolawaktu', function (Blueprint $table) {
            $table->bigIncrements('idkelolawaktu');
            $table->Integer('idinstansi');
            $table->char('jammasuk', 6);
            $table->char('jamkeluar', 6);
            $table->timestamps();
        });

        $kelolawaktu = ["08:00", "13:00"];
        DB::connection("mysql")->table("kelolawaktu")->insert([
            "idinstansi" => 1,
            "jammasuk" => $kelolawaktu[0],
            "jamkeluar" => $kelolawaktu[1],
        ]);

        Schema::create('kelolalibur', function (Blueprint $table) {
            $table->bigIncrements('idlibur');
            $table->Integer('idinstansi');
            $table->String('hari');
            $table->timestamps();
        });
        $hari = ["sabtu", "minggu"];
        foreach ($hari as $h) {
            DB::connection("mysql")->table("kelolalibur")->insert([
                "idinstansi" => 1,
                "hari" => $h,
            ]);
        }

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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class siswaM extends Model
{
    use HasFactory;
    protected $table = 'siswa';
    protected $primaryKey = 'idsiswa';
    protected $connection = 'mysql2';
    protected $guarded = [];

    public function kartupelajar() {
        return $this -> hasOne(kartupelajarM::class, 'nisn', 'nisn');
    }

    public function jurusan() {
        return $this -> belongsTo(jurusanM::class, 'idjurusan', 'idjurusan');
    }

    public function detailsiswa() {
        return $this -> hasOne(detailsiswaM::class, 'nisn', 'nisn');
    }

    public function kelas() {
        return $this -> belongsTo(kelasM::class, 'idkelas', 'idkelas');
    }
    public function instansi() {
        return $this -> hasOne(instansiM::class, 'idinstansi', 'idinstansi');
    }
}

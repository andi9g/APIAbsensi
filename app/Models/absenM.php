<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class absenM extends Model
{
    use HasFactory;
    protected $table = 'absen';
    protected $primaryKey = 'idabsen';
    protected $connection = 'mysql';
    protected $fillable = ["nisn", "tanggal", "jammasuk", "jamkeluar"];

    public function siswa()
    {
        return $this->hasOne(siswaM::class, 'nisn','nisn');
    }
}

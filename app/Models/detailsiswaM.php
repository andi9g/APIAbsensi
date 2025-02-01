<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detailsiswaM extends Model
{
    use HasFactory;
    protected $table = 'detailsiswa';
    protected $primaryKey = 'iddetailsiswa';
    protected $connection = 'mysql2';
    protected $guarded = [];

    public function siswa()
    {
        return $this->hasOne(siswaM::class, 'nisn','nisn');
    }
}

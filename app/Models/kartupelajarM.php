<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kartupelajarM extends Model
{
    use HasFactory;
    protected $table = 'kartupelajar';
    protected $primaryKey = 'idkartupelajar';
    protected $connection = 'mysql2';
    protected $guarded = [];

    public function siswa()
    {
        return $this->hasOne(siswaM::class, 'nis','nis');
    }
}

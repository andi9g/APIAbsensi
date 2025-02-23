<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bacakartuM extends Model
{
    use HasFactory;
    protected $table = 'bacakartu';
    protected $primaryKey = 'idbacakartu';
    protected $connection = 'mysql';
    protected $fillable = ["uuid", "kodealat", "idinstansi"];

    public function kartupelajar()
    {
        return $this->hasOne(kartupelajarM::class, 'uuid','uuid');
    }
}

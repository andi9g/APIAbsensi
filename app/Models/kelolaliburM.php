<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kelolaliburM extends Model
{
    use HasFactory;
    protected $table = 'kelolalibur';
    protected $primaryKey = 'idkelolalibur';
    protected $connection = 'mysql';
    protected $guarded = [];

    public function instansi()
    {
        return $this->hasOne(instansiM::class, 'idinstansi','idinstansi');
    }
}

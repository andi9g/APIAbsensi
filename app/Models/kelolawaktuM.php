<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kelolawaktuM extends Model
{
    use HasFactory;
    protected $table = 'kelolawaktu';
    protected $primaryKey = 'idkelolawaktu';
    protected $connection = 'mysql';
    protected $guarded = [];

    public function instansi()
    {
        return $this->hasOne(instansiM::class, 'idinstansi','idinstansi');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class alatabsensiM extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 'alatabsensi';
    protected $primaryKey = 'idalatabsensi';
    protected $connection = 'mysql';
    protected $fillable = ["idinstansi", "fungsi", "kodealat", "timestamp", "pascode"];
    protected $guarded = [];

    public function instansi()
    {
        return $this->hasOne(instansiM::class, 'idinstansi','idinstansi');
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}

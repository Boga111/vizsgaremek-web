<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asztalok extends Model
{
    protected $table = 'asztalok';
    protected $primaryKey = 'asztalszam';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['asztalszam','fo_db'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etlap extends Model
{
    protected $table = 'etlap'; 
    protected $primaryKey = 'termek_nev'; 
    public $incrementing = false; 
    protected $keyType = 'string'; 
    public $timestamps = false; 
    protected $fillable = [
        'termek_nev',
        'tipus',
        'netto_egyseg_ar',
        'afa_kulcs',
        'akcio_szazalek',
        'mennyisegi_egyseg',
        'kep',
        'leiras'
    ];
}
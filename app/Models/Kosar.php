<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kosar extends Model
{
    protected $table = 'kosar';
    protected $primaryKey = 'kosar_id';
    public $timestamps = false;

    protected $fillable = [
    'rendeles_id',
    'termek_nev',
    'term_db_szam',
    'netto_egyseg_ar',
    'afa_kulcs',
    'kedvezmeny_szazalek'
];
}
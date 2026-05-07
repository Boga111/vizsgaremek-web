<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Szamla extends Model
{
    protected $table = 'szamla';
    protected $primaryKey = 'szamla_id';
    public $timestamps = false;

    protected $fillable = [
        'rendeles_id',
        'nev',
        'cim',
        'tipus',
        'kibocsatas_datuma',
        'teljesites_datuma',
        'fiz_mod',
        'szla_nev',
        'szla_evszam',
        'szla_sorszam',
        'szla_teljsorszam',
        'vegosszeg'
    ];
}
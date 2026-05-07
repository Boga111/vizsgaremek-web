<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Szallitasi_cim extends Model
{
    protected $table = 'szallitasi_cim';
    protected $primaryKey = 'cim_id';
    public $timestamps = false;

    protected $fillable = ['email','cim','megjegyzes'];
}
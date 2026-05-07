<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Helyfoglalas extends Model
{
    protected $table = "helyfoglalas";
    protected $primaryKey = "foglalas_id";
    public $timestamps = false;

    protected $fillable = ['nev', 'email','asztalszam','idopont','fo_db', 'allapot'];
}
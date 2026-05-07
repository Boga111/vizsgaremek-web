<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rendeles extends Model
{
    protected $table = 'rendeles';
    protected $primaryKey = 'rendeles_id';
    public $timestamps = false;

    protected $fillable = [
        'rendeles_tipus',
        'email',
        'futar_email',
        'cim_id',
        'fiz_mod',
        'allapot',
        'vegosszeg',
        'rendeles_ido'
    ];
}
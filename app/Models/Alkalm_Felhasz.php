<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alkalm_Felhasz extends Model
{
    protected $table = 'alkalm_felhasz';
    protected $primaryKey = 'felhaszn_id';
    public $timestamps = false;

    protected $fillable = [
        'felhasznalok',
        'pin'
    ];
}

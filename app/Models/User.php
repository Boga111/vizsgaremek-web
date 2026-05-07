<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email', 
        'nev', 
        'jelszo', 
        'jogosultsag', 
        'tel_szam',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'jelszo',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'jelszo' => 'hashed',
        ];
    }

    protected $table = 'felhasznalo'; 
    protected $primaryKey = 'email'; 
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    public function getAuthPassword(){ 
        return $this->jelszo; 
    }

    public function szallitasiCimek(){
        return $this->hasMany(Szallitasi_cim::class, 'email', 'email');
    }
}

<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Reporter extends Authenticatable
{
    protected $table = 'reporter';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'umur',
        'alamat',
        'tanggal_lahir',
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}

<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Reporter extends Authenticatable
{
    protected $table = 'reporter';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    protected $appends = ['umur'];

    public function getUmurAttribute()
    {
        if ($this->tanggal_lahir) {
            return \Carbon\Carbon::parse($this->tanggal_lahir)->age;
        }
        return null;
    }
}

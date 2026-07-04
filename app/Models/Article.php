<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory;

    protected $table = 'articles';

    protected $fillable = [
        'judul',
        'posisi',
        'isi',
        'foto',
        'reporter',
        'kategori_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }
}

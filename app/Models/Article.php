<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory;

    protected $table = 'artikel';
    public $timestamps = false;

    protected $fillable = [
        'judul',
        'isi',
        'foto',
        'posisi',
        'reporter_id',
        'kategori_id',
        'lokasi_id'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(Reporter::class, 'reporter_id');
    }
}

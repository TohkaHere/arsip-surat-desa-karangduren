<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Surat extends Model
{
    protected $fillable = [
        'nomor_surat',
        'kategori_id',
        'judul',
        'file_path',
        'waktu_pengarsipan'
    ];

    protected $casts = [
        'waktu_pengarsipan' => 'datetime'
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }
}

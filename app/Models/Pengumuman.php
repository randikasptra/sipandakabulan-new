<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumumans';

    protected $fillable = [
        'judul',
        'isi',
        'file',
        'desa_ids',
    ];

    // ✅ CRITICAL: Cast JSON ke array
    protected $casts = [
        'desa_ids' => 'array',
    ];

    // Relasi ke Desa (untuk ditampilkan di UI)
    public function desas()
    {
        return $this->belongsToMany(Desa::class, 'desa_ids', 'id', 'id');
    }

    // Helper untuk cek apakah desa tertentu menerima pengumuman ini
    public function isForDesa($desaId)
    {
        return in_array($desaId, $this->desa_ids ?? []);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanIndikator extends Model
{
    use HasFactory;

    protected $fillable = [
        'desa_id',
        'indikator_id',
        'user_id',
        'tahun',
        'catatan',
    ];

    /**
     * Relasi ke Desa
     */
    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    /**
     * Relasi ke Indikator
     */
    public function indikator()
    {
        return $this->belongsTo(IndikatorKlaster::class, 'indikator_id');
    }

    /**
     * Relasi ke User (pembuat catatan)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
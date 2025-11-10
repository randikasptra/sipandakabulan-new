<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndikatorOpsiNilai extends Model
{
    use HasFactory;

    protected $table = 'indikator_opsi_nilai';

    protected $fillable = [
        'indikator_id',
        'label',
        'poin',
    ];

    // Relasi: satu opsi nilai milik satu indikator
    public function indikator()
    {
        return $this->belongsTo(IndikatorKlaster::class, 'indikator_id');
    }
}

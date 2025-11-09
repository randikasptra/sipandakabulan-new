<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klaster extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'nilai_em',
        'nilai_maksimal',
        'progres',
    ];

    // Relasi: Klaster punya banyak indikator
    public function indikators()
    {
        return $this->hasMany(IndikatorKlaster::class, 'klaster_id');
    }

    // Relasi: Klaster punya banyak penilaian
    public function penilaians()
    {
        return $this->hasMany(Penilaian::class, 'klaster_id');
    }
}

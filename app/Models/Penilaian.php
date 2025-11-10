<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'penilaians';

    protected $fillable = [
        'klaster_id',
        'indikator_id',
        'desa_id',
        'user_id',
        'nilai',
        'tahun',
        'bulan',
    ];

    // Relasi
    public function klaster()
    {
        return $this->belongsTo(Klaster::class);
    }

    public function indikator()
    {
        return $this->belongsTo(IndikatorKlaster::class, 'indikator_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function berkasUploads()
    {
        return $this->hasMany(BerkasUpload::class, 'penilaian_id');
    }
    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

}

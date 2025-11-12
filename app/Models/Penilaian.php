<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'penilaians';

    protected $fillable = [
        'desa_id',
        'user_id',
        'klaster_id',
        'indikator_id',
        'nilai',
        'tahun',
        'bulan',
        'total_nilai',
        'status',
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

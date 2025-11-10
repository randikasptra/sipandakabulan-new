<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'klaster_id',
        'indikator_id',
        'tahun',
        'bulan',
        'total_nilai',
        'status',
    ];

    // Relasi: penilaian dimiliki oleh user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: penilaian terkait dengan klaster
    public function klaster()
    {
        return $this->belongsTo(Klaster::class);
    }

    // Relasi: penilaian terkait dengan indikator
    public function indikator()
    {
        return $this->belongsTo(IndikatorKlaster::class, 'indikator_id');
    }

    // Relasi: penilaian punya banyak berkas upload
    public function berkasUploads()
    {
        return $this->hasMany(BerkasUpload::class, 'penilaian_id');
    }
}

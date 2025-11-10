<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriUpload extends Model
{
    use HasFactory;

    protected $fillable = [
        'indikator_id',
        'nama_kategori',
    ];

    // Relasi: satu kategori upload milik satu indikator
    public function indikator()
    {
        return $this->belongsTo(IndikatorKlaster::class, 'indikator_id');
    }

    // Relasi: kategori upload bisa punya banyak file upload
    public function berkasUploads()
    {
        return $this->hasMany(BerkasUpload::class, 'kategori_upload_id');
    }
}

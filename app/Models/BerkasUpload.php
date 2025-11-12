<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasUpload extends Model
{
    use HasFactory;

    protected $fillable = [
        'penilaian_id',
        'kategori_upload_id',
        'path_file',
        'nilai',
    ];

    // Relasi: file upload milik penilaian
    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class, 'penilaian_id');
    }

    // Relasi: file upload milik kategori upload
    public function kategoriUpload()
    {
        return $this->belongsTo(KategoriUpload::class, 'kategori_upload_id');
    }
}

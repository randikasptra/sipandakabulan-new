<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndikatorKlaster extends Model
{
    use HasFactory;

    protected $fillable = [
        'klaster_id',
        'nama_indikator',
        'slug',
        'total_nilai',
        'template_excel',
    ];

    // Relasi: satu indikator milik satu klaster
    public function klaster()
    {
        return $this->belongsTo(Klaster::class, 'klaster_id');
    }

    // Relasi: indikator punya banyak opsi nilai
    public function opsiNilai()
    {
        return $this->hasMany(IndikatorOpsiNilai::class, 'indikator_id');
    }

    // Relasi: indikator punya banyak kategori upload
    public function kategoriUploads()
    {
        return $this->hasMany(KategoriUpload::class, 'indikator_id');
    }

    // Relasi: indikator bisa punya banyak penilaian
    public function penilaians()
    {
        return $this->hasMany(Penilaian::class, 'indikator_id');
    }
}

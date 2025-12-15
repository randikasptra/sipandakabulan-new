<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriUpload extends Model
{
    protected $fillable = [
        'indikator_id',
        'nama_kategori',
        'is_custom',
        'desa_id',
    ];

    // Relasi
    public function indikator()
    {
        return $this->belongsTo(IndikatorKlaster::class, 'indikator_id');
    }

    public function berkasUploads()
    {
        return $this->hasMany(BerkasUpload::class, 'kategori_upload_id');
    }

    // Scope: kategori default (dari seeder)
    public function scopeDefault($query)
    {
        return $query->where('is_custom', false);
    }

    // Scope: kategori custom user
    public function scopeCustom($query, $desaId = null)
    {
        $query = $query->where('is_custom', true);

        if ($desaId) {
            $query->where('desa_id', $desaId);
        }

        return $query;
    }
}

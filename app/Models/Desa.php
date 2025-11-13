<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_desa',
        'kode_desa',
        'alamat_kantor',
        'nama_kades',
        'no_telp',
    ];

    /**
     * Relasi ke users (operator desa)
     * Satu desa bisa punya banyak user
     */
    public function users()
    {
        return $this->hasMany(User::class, 'desa_id');
    }

    /**
     * Relasi ke penilaians
     * Satu desa bisa punya banyak penilaian
     */
    public function penilaians()
    {
        return $this->hasMany(Penilaian::class, 'desa_id');
    }

    /**
     * Relasi ke kecamatan (opsional)
     */
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    /**
     * Accessor untuk mendapatkan status kelengkapan data
     */
    public function getKelengkapanDataAttribute()
    {
        // Hitung berapa cluster yang sudah diisi
        $totalCluster = 6; // Kelembagaan + 5 Cluster
        $clusterTerisi = $this->penilaians()
            ->distinct('jenis_cluster')
            ->count();

        return round(($clusterTerisi / $totalCluster) * 100, 2);
    }

    /**
     * Scope untuk filter desa berdasarkan kecamatan
     */
    public function scopeByKecamatan($query, $kecamatanId)
    {
        return $query->where('kecamatan_id', $kecamatanId);
    }
}

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
     * Relasi ke user (operator desa)
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relasi ke penilaians
     * Satu desa bisa punya banyak penilaian
     */
    public function penilaians()
    {
        return $this->hasMany(Penilaian::class, 'desa_id');
    }
}

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
     * Relasi ke user
     * Satu desa bisa punya banyak user (operator)
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}

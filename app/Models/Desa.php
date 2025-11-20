<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Desa extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nama_desa',
        'kode_desa',
        'alamat_kantor',
        'nama_kades',
        'no_telp',
    ];

    protected $dates = ['deleted_at'];

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
     */
    public function penilaians()
    {
        return $this->hasMany(Penilaian::class, 'desa_id');
    }

    /**
     * Get slug untuk email generation
     */
    public function getSlugAttribute()
    {
        return \Illuminate\Support\Str::slug($this->nama_desa);
    }

    /**
     * Get auto-generated email
     */
    public function getAutoEmailAttribute()
    {
        return $this->slug . '@tasikdesa.com';
    }
}

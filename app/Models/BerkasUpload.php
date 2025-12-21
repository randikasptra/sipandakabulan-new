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

    // ✅ TAMBAHKAN ACCESSOR INI
    public function getFullUrlAttribute()
    {
        if (!$this->path_file) {
            return null;
        }

        $supabaseUrl = config('services.supabase.url');
        $bucket = config('services.supabase.bucket', 'uploads');

        return "{$supabaseUrl}/storage/v1/object/public/{$bucket}/{$this->path_file}";
    }

    // ✅ Accessor untuk nama file saja
    public function getFilenameAttribute()
    {
        return basename($this->path_file);
    }

    // ✅ Accessor untuk ekstensi file
    public function getExtensionAttribute()
    {
        return strtolower(pathinfo($this->path_file, PATHINFO_EXTENSION));
    }
}

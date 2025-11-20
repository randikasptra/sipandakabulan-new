<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumumans';

    protected $fillable = [
        'judul',
        'isi',
        'file',
        'desa_ids',
    ];

    protected $casts = [
        'desa_ids' => 'array',
    ];

    protected $appends = ['file_url'];

    // URL download dari Supabase
    public function getFileUrlAttribute()
    {
        if (!$this->file) {
            return null;
        }

        return rtrim(env('SUPABASE_URL'), '/')
            . '/storage/v1/object/public/'
            . env('SUPABASE_STORAGE_BUCKET')
            . '/'
            . ltrim($this->file, '/');
    }

    // Cek apakah pengumuman ditujukan untuk desa tertentu
    public function isForDesa($desaId)
    {
        $arr = $this->desa_ids ?? [];
        foreach ($arr as $value) {
            if ((int)$value === (int)$desaId) {
                return true;
            }
        }
        return false;
    }

    // Query helper
    public function scopeForDesa($q, $desaId)
    {
        $id = (int) $desaId;

        return $q->where(function ($q) use ($id) {
            $q->whereRaw("JSON_CONTAINS(desa_ids, ?)", [json_encode($id)])
              ->orWhereRaw("JSON_CONTAINS(desa_ids, '\"{$id}\"')");
        });
    }
}

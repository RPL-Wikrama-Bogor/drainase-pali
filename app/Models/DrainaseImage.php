<?php
// app/Models/DrainaseImage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrainaseImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'identifier',
        'nama_ruas',
        'filename',
        'path',
        'original_name',
        'mime_type',
        'size',
        'description'
    ];

    protected $casts = [
        'size' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get URL gambar
     */
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }

    /**
     * Get path storage gambar
     */
    public function getStoragePathAttribute()
    {
        return storage_path('app/public/' . $this->path);
    }

    /**
     * Cek apakah gambar ada
     */
    public function imageExists()
    {
        return file_exists($this->storage_path);
    }
}

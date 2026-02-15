<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtikelJurusan extends Model
{
    protected $table = 'artikel_jurusan';

    protected $fillable = [
        'jurusan_id',
        'judul',
        'deskripsi',
        'file_upload_id',
        'gambar_upload_id',
        'created_by_user_id'
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
}

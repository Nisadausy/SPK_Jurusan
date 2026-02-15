<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformasiJurusan extends Model
{
    protected $table = 'informasi_jurusan';

    protected $primaryKey = 'jurusan_id';
    public $incrementing = false;

    protected $fillable = [
        'jurusan_id',
        'fasilitas',
        'updated_by_user_id'
    ];
}

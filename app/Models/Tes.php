<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tes extends Model
{
    protected $table = 'tes';

    protected $fillable = [
        'siswa_id',
        'nilai_akademik',
        'skor_minat_bakat',
        'tinggi_badan',
        'berat_badan',
        'buta_warna',
        'minat_jurusan_1_id',
        'minat_jurusan_2_id'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function hasilSaw()
    {
        return $this->hasMany(HasilSaw::class);
    }

    public function jawabanMinat()
    {
        return $this->hasMany(JawabanMinat::class);
    }
}

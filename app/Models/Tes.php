<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\TesPdf;

class Tes extends Model
{
    protected $table    = 'tes';
    protected $fillable = [
        'siswa_id', 'nilai_akademik', 'skor_minat_bakat',
        'tinggi_badan', 'berat_badan', 'buta_warna',
        'minat_jurusan_1_id', 'minat_jurusan_2_id',
    ];
    protected $casts = ['buta_warna' => 'boolean'];

    public function siswa()         { return $this->belongsTo(Siswa::class); }
    public function minatJurusan1() { return $this->belongsTo(Jurusan::class, 'minat_jurusan_1_id'); }
    public function minatJurusan2() { return $this->belongsTo(Jurusan::class, 'minat_jurusan_2_id'); }
    public function hasilSaw()      { return $this->hasMany(HasilSaw::class); }

    public function tesPDF()
{
    return $this->hasOne(TesPdf::class, 'tes_id');
}

    /** Rekomendasi = hasil SAW peringkat 1 */
    public function rekomendasiTeratas()
    {
        return $this->hasOne(HasilSaw::class)->where('peringkat', 1)->with('jurusan');
    }
}
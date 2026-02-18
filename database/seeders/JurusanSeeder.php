<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        $jurusans = [
            ['nama_jurusan' => 'Teknik Alat Berat',                          'is_active' => true],
            ['nama_jurusan' => 'Teknik Kendaraan Ringan (Otomotif)',          'is_active' => true],
            ['nama_jurusan' => 'Teknik Sepeda Motor',                         'is_active' => true],
            ['nama_jurusan' => 'Teknik Pemesinan',                            'is_active' => true],
            ['nama_jurusan' => 'Teknik Mekatronika',                          'is_active' => true],
            ['nama_jurusan' => 'Teknik Konstruksi & Perumahan',               'is_active' => true],
            ['nama_jurusan' => 'Desain Pemodelan & Informasi Bangunan (DPIB)','is_active' => true],
            ['nama_jurusan' => 'Teknik Instalasi Listrik',                    'is_active' => true],
            ['nama_jurusan' => 'Teknik Pembangkit Tenaga Listrik',            'is_active' => true],
            ['nama_jurusan' => 'Teknik Audio Video',                          'is_active' => true],
            ['nama_jurusan' => 'Teknik Komputer & Jaringan (TKJ)',            'is_active' => true],
            ['nama_jurusan' => 'Desain Komunikasi Visual (DKV)',              'is_active' => true],
        ];

        foreach ($jurusans as $j) {
            Jurusan::updateOrCreate(
                ['nama_jurusan' => $j['nama_jurusan']],
                ['is_active'    => $j['is_active']]
            );
        }

        $this->command->info('✅ ' . count($jurusans) . ' jurusan berhasil di-seed!');
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tes', function (Blueprint $table) {
            $table->unsignedBigInteger('minat_jurusan_1_id')
                  ->nullable()
                  ->after('skor_minat_bakat');

            $table->unsignedBigInteger('minat_jurusan_2_id')
                  ->nullable()
                  ->after('minat_jurusan_1_id');

            $table->foreign('minat_jurusan_1_id')
                  ->references('id')->on('jurusan')->nullOnDelete();

            $table->foreign('minat_jurusan_2_id')
                  ->references('id')->on('jurusan')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('tes', function (Blueprint $table) {
            $table->dropForeign(['minat_jurusan_1_id']);
            $table->dropForeign(['minat_jurusan_2_id']);
            $table->dropColumn(['minat_jurusan_1_id', 'minat_jurusan_2_id']);
        });
    }
};
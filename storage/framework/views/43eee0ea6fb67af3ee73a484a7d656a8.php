
<?php $__env->startSection('title','Data Siswa'); ?>
<?php $__env->startSection('page-title','Data Siswa'); ?>
<?php $__env->startSection('page-sub','FR-BK-05 · Lihat hasil rekomendasi siswa'); ?>

<?php $__env->startSection('content'); ?>
<div class="alert alert-info">ℹ️ Data bersifat <strong>read-only</strong>. Guru BK hanya dapat melihat hasil rekomendasi siswa.</div>

<div class="card">
    <div class="card-head">
        <div class="card-title">Daftar Siswa</div>
        <form method="GET" style="display:flex;gap:8px;">
            <input name="search" class="form-control" style="width:220px;padding:7px 12px;" placeholder="🔍 Cari nama siswa..." value="<?php echo e(request('search')); ?>"/>
            <button class="btn btn-primary btn-sm">Cari</button>
            <?php if(request('search')): ?>
                <a href="<?php echo e(route('bk.siswa.index')); ?>" class="btn btn-outline btn-sm">Reset</a>
            <?php endif; ?>
        </form>
    </div>
    <table>
        <thead>
            <tr>
                <th>Nama Siswa</th><th>Sekolah Asal</th><th>Rekomendasi SAW</th>
                <th>Minat 1</th><th>Minat 2</th><th>Sesuai?</th><th>Jml Tes</th><th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $siswas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $siswa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $lastTes = $siswa->tes->first();
                $rek     = $lastTes?->rekomendasiTeratas?->jurusan?->nama_jurusan;
                $m1      = $lastTes?->minatJurusan1?->nama_jurusan;
                $m2      = $lastTes?->minatJurusan2?->nama_jurusan;
                $sesuai  = $lastTes
                    && $lastTes->rekomendasiTeratas
                    && $lastTes->rekomendasiTeratas->jurusan_id === $lastTes->minat_jurusan_1_id;
            ?>
            <tr>
                <td style="font-weight:700;color:var(--primary-dark);"><?php echo e($siswa->user->nama ?? '-'); ?></td>
                <td style="font-size:11.5px;color:var(--text-dim);"><?php echo e($siswa->sekolah_asal ?? '-'); ?></td>
                <td>
                    <?php if($rek): ?>
                        <span class="badge badge-blue"><?php echo e($rek); ?></span>
                    <?php else: ?>
                        <span class="badge badge-gray">Belum tes</span>
                    <?php endif; ?>
                </td>
                <td><span class="badge badge-gray"><?php echo e($m1 ?? '-'); ?></span></td>
                <td><span class="badge badge-gray"><?php echo e($m2 ?? '-'); ?></span></td>
                <td>
                    <?php if($lastTes && $lastTes->rekomendasiTeratas): ?>
                        <span class="badge <?php echo e($sesuai ? 'badge-green':'badge-red'); ?>">
                            <?php echo e($sesuai ? '✅ Sesuai':'⚠ Berbeda'); ?>

                        </span>
                    <?php else: ?>
                        —
                    <?php endif; ?>
                </td>
                <td style="text-align:center;font-weight:700;"><?php echo e($siswa->tes->count()); ?></td>
                <td><a href="<?php echo e(route('bk.siswa.show', $siswa->id)); ?>" class="btn btn-outline btn-sm">Detail</a></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="8" style="text-align:center;color:var(--text-dim);padding:24px;">Tidak ada data siswa.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div style="padding:14px 20px;border-top:1px solid var(--border);"><?php echo e($siswas->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.bk', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SPK Jurusan SMK\4 Backup\SPK_Jurusan\SPK_Jurusan_Mapel Dipisah\resources\views/pages/bk/siswa/index.blade.php ENDPATH**/ ?>
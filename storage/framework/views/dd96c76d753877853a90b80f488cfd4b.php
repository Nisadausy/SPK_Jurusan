
<?php $__env->startSection('title','Kelola Akun Siswa'); ?>
<?php $__env->startSection('content'); ?>

<div class="page-title-row">
    <div>
        <div class="page-title">👨‍🎓 Akun Siswa</div>
        <div class="page-subtitle">FR-A-05, FR-A-06 · Edit profil dan kredensial siswa</div>
    </div>
    <form method="GET" style="display:flex;gap:8px;">
        <input type="text" name="search" value="<?php echo e(request('search')); ?>"
            placeholder="Cari nama / email..."
            class="form-control-custom"
            style="width:240px;">
        <button type="submit" class="btn-custom btn-dark-custom">Cari</button>
    </form>
</div>

<?php if(session('success')): ?>
<div class="flash-success">
    <span>✅ <?php echo e(session('success')); ?></span>
    <button onclick="this.parentElement.remove()" style="background:none;border:none;cursor:pointer;color:#065f46;font-size:16px;">✕</button>
</div>
<?php endif; ?>

<div class="card-soft">
    <div style="overflow:hidden;">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Nama & Email</th>
                    <th>Sekolah Asal</th>
                    <th>Status</th>
                    <th>Daftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $siswas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $siswa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:9px;">
                            <div class="tb-av" style="width:30px;height:30px;font-size:11px;flex-shrink:0;">
                                <?php echo e(strtoupper(substr($siswa->user->nama ?? 'S', 0, 1))); ?>

                            </div>
                            <div>
                                <div style="font-weight:700;font-size:13px;color:var(--ink);"><?php echo e($siswa->user->nama ?? '-'); ?></div>
                                <div style="font-size:11px;color:var(--dim);"><?php echo e($siswa->user->email ?? '-'); ?></div>
                            </div>
                        </div>
                    </td>
                    <td style="font-size:12.5px;"><?php echo e($siswa->sekolah_asal ?? '-'); ?></td>
                    <td>
                        <?php if($siswa->user->is_active): ?>
                            <span class="badge-custom badge-green">✅ Aktif</span>
                        <?php else: ?>
                            <span class="badge-custom badge-red">❌ Nonaktif</span>
                        <?php endif; ?>
                    </td>
                    <td style="font-size:11.5px;color:var(--dim);"><?php echo e($siswa->created_at?->format('d M Y') ?? '-'); ?></td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="<?php echo e(route('admin.siswa.edit', $siswa->id)); ?>" class="btn-custom btn-outline-blue">✏️ Edit</a>
                            <form method="POST" action="<?php echo e(route('admin.siswa.status', $siswa->id)); ?>" style="display:inline;">
                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                <button type="submit" class="btn-custom <?php echo e($siswa->user->is_active ? 'btn-outline-red' : 'btn-outline-green'); ?>">
                                    <?php echo e($siswa->user->is_active ? '🔴 Nonaktifkan' : '🟢 Aktifkan'); ?>

                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" style="padding:32px;text-align:center;color:var(--dim2);font-size:13px;">Belum ada data siswa.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div style="padding:14px 16px;border-top:1px solid var(--border);">
        <?php echo e($siswas->appends(request()->query())->links()); ?>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SPK Jurusan SMK\4 Backup\SPK_Jurusan\SPK_Jurusan_Mapel Dipisah\resources\views/pages/admin/siswa/index.blade.php ENDPATH**/ ?>
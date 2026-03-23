
<?php $__env->startSection('title','Artikel Jurusan'); ?>
<?php $__env->startSection('page-title','Artikel Jurusan'); ?>
<?php $__env->startSection('page-sub','FR-BK-07 · Kelola artikel jurusan'); ?>

<?php $__env->startSection('content'); ?>
<div style="display:flex;justify-content:flex-end;margin-bottom:16px;">
    <a href="<?php echo e(route('bk.artikel.create')); ?>" class="btn btn-primary">➕ Tambah Artikel</a>
</div>
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;">
    <?php $__empty_1 = true; $__currentLoopData = $artikels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="card" style="overflow:hidden;">
        <?php if($a->gambarUpload): ?>
        <img src="<?php echo e(Storage::url($a->gambarUpload->storage_path)); ?>" style="width:100%;height:130px;object-fit:cover;"/>

        <?php else: ?>
            <div style="height:130px;background:linear-gradient(135deg,var(--primary-dark),var(--primary));display:flex;align-items:center;justify-content:center;font-size:40px;">📄</div>
        <?php endif; ?>
        <div style="padding:14px;">
            <div style="font-size:10px;font-weight:700;text-transform:uppercase;color:var(--accent);margin-bottom:5px;"><?php echo e($a->jurusan->nama_jurusan ?? '-'); ?></div>
            <div style="font-size:13px;font-weight:700;color:var(--primary-dark);line-height:1.4;margin-bottom:8px;"><?php echo e($a->judul); ?></div>
            <div style="font-size:11px;color:var(--text-dim);">📅 <?php echo e($a->created_at->translatedFormat('d M Y')); ?></div>
            <?php if($a->fileUpload): ?>
                <div style="font-size:11px;color:var(--blue);margin-top:4px;">📎 <?php echo e($a->fileUpload->file_name); ?></div>
            <?php endif; ?>
        </div>
        <div style="padding:10px 14px;border-top:1px solid var(--border);display:flex;gap:6px;">
            <a href="<?php echo e(route('bk.artikel.edit', $a->id)); ?>" class="btn btn-outline btn-sm">✏️ Edit</a>
            <form method="POST" action="<?php echo e(route('bk.artikel.destroy', $a->id)); ?>" onsubmit="return confirm('Hapus artikel ini?')">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button class="btn btn-danger btn-sm">🗑️ Hapus</button>
            </form>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div style="grid-column:1/-1;text-align:center;padding:48px;color:var(--text-dim);">
        Belum ada artikel. <a href="<?php echo e(route('bk.artikel.create')); ?>" style="color:var(--primary);">Tambah sekarang</a>
    </div>
    <?php endif; ?>
</div>
<div style="margin-top:16px;"><?php echo e($artikels->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.bk', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SPK Jurusan SMK\4 Backup\SPK_Jurusan\SPK_Jurusan_Mapel Dipisah\resources\views/pages/bk/artikel/index.blade.php ENDPATH**/ ?>
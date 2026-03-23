
<?php $__env->startSection('title','Tambah Artikel'); ?>
<?php $__env->startSection('page-title','Tambah Artikel'); ?>
<?php $__env->startSection('page-sub','FR-BK-07 · Buat artikel jurusan baru'); ?>

<?php $__env->startSection('content'); ?>
<a href="<?php echo e(route('bk.artikel.index')); ?>" class="btn btn-outline btn-sm" style="margin-bottom:16px;">← Kembali</a>
<div class="card" style="padding:24px;max-width:680px;">
    <div style="font-family:'Playfair Display',serif;font-size:15px;font-weight:800;color:var(--primary-dark);margin-bottom:20px;">✏️ Tambah Artikel Baru</div>
    <form method="POST" action="<?php echo e(route('bk.artikel.store')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label class="form-label">Judul <span class="req">*</span></label>
            <input name="judul" class="form-control" value="<?php echo e(old('judul')); ?>" required/>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Jurusan <span class="req">*</span></label>
                <?php if($jurusans->count() === 1): ?>
                    
                    <input type="hidden" name="jurusan_id" value="<?php echo e($jurusans->first()->id); ?>">
                    <input type="text" class="form-control" value="<?php echo e($jurusans->first()->nama_jurusan); ?>" disabled
                        style="background:#f1f5f9;color:#64748b;cursor:not-allowed;">
                <?php else: ?>
                    <select name="jurusan_id" class="form-control" required>
                        <option value="">Pilih jurusan...</option>
                        <?php $__currentLoopData = $jurusans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($j->id); ?>" <?php echo e(old('jurusan_id') == $j->id ? 'selected':''); ?>><?php echo e($j->nama_jurusan); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label class="form-label">Upload Gambar</label>
                <input name="gambar" type="file" accept=".jpg,.jpeg" class="form-control"/>
                <div class="form-hint">Format: JPG, maks. 8MB</div>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Deskripsi <span class="req">*</span></label>
            <textarea name="deskripsi" class="form-control" required><?php echo e(old('deskripsi')); ?></textarea>
        </div>
        <div class="form-group">
            <label class="form-label">File Pendukung</label>
            <input name="file" type="file" accept=".pdf,.mp4" class="form-control"/>
            <div class="form-hint">Format: PDF (maks 8MB) atau MP4 (maks 50MB)</div>
        </div>
        <div class="form-actions">
            <a href="<?php echo e(route('bk.artikel.index')); ?>" class="btn btn-outline">Batal</a>
            <button class="btn btn-primary">💾 Simpan Artikel</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.bk', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SPK Jurusan SMK\4 Backup\SPK_Jurusan\SPK_Jurusan_Mapel Dipisah\resources\views/pages/bk/artikel/create.blade.php ENDPATH**/ ?>
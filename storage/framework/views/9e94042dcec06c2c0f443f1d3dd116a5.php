


<?php $__env->startSection('title', 'Profil Saya'); ?>
<?php $__env->startSection('page-title', 'Profil Saya'); ?>
<?php $__env->startSection('page-sub', 'FR-BK-04 · Data pribadi guru BK'); ?>

<?php $__env->startSection('content'); ?>


<?php if(session('warning')): ?>
    <div style="background:#fff7ed;border:1px solid #fdba74;padding:10px;margin-bottom:10px;color:#9a3412;">
        ⚠️ <?php echo e(session('warning')); ?>

    </div>
<?php endif; ?>

<div style="display:grid;grid-template-columns:300px 1fr;gap:20px;align-items:start;">

    
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:24px;box-shadow:0 1px 3px rgba(0,0,0,.05);text-align:center;">

        
        <div style="width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,#f0a500,#f97316);display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-size:26px;font-weight:800;color:#fff;margin:0 auto 14px;">
            <?php echo e(strtoupper(substr($user->nama ?? 'G', 0, 1))); ?>

        </div>

        <div style="font-family:'Syne',sans-serif;font-size:16px;font-weight:800;color:#0d1117;margin-bottom:4px;">
            <?php echo e($user->nama ?? '-'); ?>

        </div>
        <div style="font-size:12px;color:#64748b;margin-bottom:16px;">
            <?php echo e($user->email ?? '-'); ?>

        </div>

        
        <?php if($user->is_active): ?>
            <span style="background:#ecfdf5;color:#059669;border:1px solid #a7f3d0;font-size:10.5px;font-weight:700;padding:3px 12px;border-radius:100px;">✅ Aktif</span>
        <?php else: ?>
            <span style="background:#fef2f2;color:#dc2626;border:1px solid #fecaca;font-size:10.5px;font-weight:700;padding:3px 12px;border-radius:100px;">❌ Nonaktif</span>
        <?php endif; ?>


        <div style="margin-top:14px;padding-top:14px;border-top:1px solid #f1f5f9;">
            <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;margin-bottom:6px;">JURUSAN</div>
            <?php if($guruBk->jurusan): ?>
                <span style="background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;font-size:11px;font-weight:700;padding:3px 10px;border-radius:100px;">
                    <?php echo e($guruBk->jurusan->nama_jurusan); ?>

                </span>
            <?php else: ?>
                <span style="font-size:13px;color:#94a3b8;">—</span>
            <?php endif; ?>
        </div>

        <div style="margin-top:14px;padding-top:14px;border-top:1px solid #f1f5f9;">
            <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;margin-bottom:6px;">BERGABUNG</div>
            <div style="font-size:12.5px;color:#64748b;"><?php echo e($user->created_at?->translatedFormat('d F Y')); ?></div>
        </div>

        
        <a href="<?php echo e(route('bk.password.index')); ?>"
           style="display:block;margin-top:18px;background:#f8fafc;color:#374151;border:1.5px solid #e2e8f0;border-radius:9px;padding:8px 14px;font-size:12.5px;font-weight:700;text-decoration:none;transition:all .15s;"
           onmouseover="this.style.background='#f1f5f9'"
           onmouseout="this.style.background='#f8fafc'">
            🔒 Ubah Password
        </a>
    </div>

    
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:26px;box-shadow:0 1px 3px rgba(0,0,0,.05);">

        <div style="font-family:'Syne',sans-serif;font-size:15px;font-weight:800;color:#0d1117;margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid #f1f5f9;">
            ✏️ Edit Data Profil
        </div>

        <form method="POST" action="<?php echo e(route('bk.profil.update')); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            
            <div style="margin-bottom:14px;">
                <label style="display:block;font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;margin-bottom:6px;">
                    Nama Lengkap *
                </label>
                <input type="text" name="nama"
                       value="<?php echo e(old('nama', $user->nama)); ?>"
                       required
                       style="width:100%;background:#f8fafc;border:1.5px solid <?php echo e($errors->has('nama') ? '#fca5a5' : '#e2e8f0'); ?>;border-radius:9px;font-family:'DM Sans',sans-serif;font-size:13px;padding:9px 13px;outline:none;color:#0d1117;"
                       onfocus="this.style.borderColor='#2563eb';this.style.background='#fff'"
                       onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc'">
                <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div style="font-size:11px;color:#dc2626;margin-top:4px;"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div style="margin-bottom:14px;">
                <label style="display:block;font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;margin-bottom:6px;">
                    Email *
                </label>
                <input type="email" name="email"
                       value="<?php echo e(old('email', $user->email)); ?>"
                       required
                       style="width:100%;background:#f8fafc;border:1.5px solid <?php echo e($errors->has('email') ? '#fca5a5' : '#e2e8f0'); ?>;border-radius:9px;font-family:'DM Sans',sans-serif;font-size:13px;padding:9px 13px;outline:none;color:#0d1117;"
                       onfocus="this.style.borderColor='#2563eb';this.style.background='#fff'"
                       onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc'">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div style="font-size:11px;color:#dc2626;margin-top:4px;"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div style="margin-bottom:14px;">
                <label style="display:block;font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;margin-bottom:6px;">
                    NIP
                </label>
                <input type="text" name='nip'
                       value="<?php echo e(old('nip', $guruBk->nip ?? '')); ?>" required
                       style="width:100%;background:#f1f5f9;border:1.5px solid #e2e8f0;border-radius:9px;font-family:'DM Sans',sans-serif;font-size:13px;padding:9px 13px;outline:none;color:#94a3b8;cursor:not-allowed;">
                <div style="font-size:11px;color:#94a3b8;margin-top:4px;">NIP hanya bisa diubah oleh Admin.</div>
            </div>

            
            <div style="display:flex;gap:9px;justify-content:flex-end;padding-top:16px;border-top:1px solid #f1f5f9;">
                <a href="<?php echo e(route('bk.dashboard')); ?>"
                   style="display:inline-flex;align-items:center;background:#f8fafc;color:#374151;border:1.5px solid #e2e8f0;padding:8px 18px;border-radius:9px;font-size:13px;font-weight:700;text-decoration:none;">
                    Batal
                </a>
                <button type="submit"
                        style="background:linear-gradient(135deg,#0d1117,#1c2333);color:#fff;border:none;padding:8px 20px;border-radius:9px;font-family:'DM Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;box-shadow:0 2px 8px rgba(0,0,0,.15);">
                    ✓ Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.bk', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SPK Jurusan SMK\4 Backup\SPK_Jurusan\SPK_Jurusan_Mapel Dipisah\resources\views/pages/bk/profil.blade.php ENDPATH**/ ?>
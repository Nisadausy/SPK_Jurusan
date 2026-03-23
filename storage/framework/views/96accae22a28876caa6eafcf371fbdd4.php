
<?php $__env->startSection('title','Dashboard'); ?>
<?php $__env->startSection('page-title','Dashboard'); ?>
<?php $__env->startSection('page-sub','Selamat datang, pantau perkembangan siswa'); ?>
<?php $__env->startPush('styles'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php
    $bulanLabel = $trenTes->map(fn($t) => \Carbon\Carbon::create($t->tahun, $t->bulan)->translatedFormat('M'));
    $bulanData  = $trenTes->pluck('total');
    $maxRekap   = $rekapJurusan->max('total') ?: 1;
?>

<div style="background:linear-gradient(135deg,#0f2548 0%,#1a3c6e 60%,#2a5298 100%);border-radius:12px;padding:24px 28px;margin-bottom:22px;color:#fff;position:relative;overflow:hidden;">
    <div style="position:absolute;top:-40px;right:-40px;width:200px;height:200px;border-radius:50%;background:rgba(255,255,255,.04);"></div>
    <div style="display:inline-flex;align-items:center;gap:6px;background:rgba(232,160,32,.2);border:1px solid rgba(232,160,32,.4);color:#f5c55a;font-size:11px;font-weight:700;padding:4px 12px;border-radius:100px;margin-bottom:10px;">👩‍🏫 Guru Bimbingan Konseling</div>
    
    <div style="font-family:'Playfair Display',serif;font-size:20px;font-weight:700;margin-bottom:4px;">Selamat Datang, <?php echo e(Auth::user()->nama); ?>!</div>
    <div style="font-size:13px;color:rgba(255,255,255,.7);">Pantau perkembangan siswa dan kelola konten jurusan dari sini.</div>
</div>

<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:22px;">
    <?php $__currentLoopData = [
        ['🎓',$totalSiswa,'Total Siswa','Terdaftar di sistem','#2563eb'],
        ['✅',$sudahTes,'Sudah Tes','Sudah mengerjakan','#16a34a'],
        ['⏳',$belumTes,'Belum Tes','Perlu tindak lanjut','#d97706'],
        ['⚠️',$minatBeda,'Minat ≠ Hasil','Perlu konseling','#dc2626'],
    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$icon,$num,$label,$sub,$color]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="card" style="padding:18px 20px;position:relative;overflow:hidden;">
        <div style="position:absolute;bottom:0;left:0;right:0;height:3px;background:<?php echo e($color); ?>;opacity:.8;"></div>
        <div style="font-size:22px;margin-bottom:12px;"><?php echo e($icon); ?></div>
        <div style="font-family:'Playfair Display',serif;font-size:28px;font-weight:800;color:var(--primary-dark);line-height:1;"><?php echo e($num); ?></div>
        <div style="font-size:12px;font-weight:700;color:var(--text-mid);margin-top:4px;"><?php echo e($label); ?></div>
        <div style="font-size:11px;color:var(--text-dim);margin-top:3px;"><?php echo e($sub); ?></div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div style="display:grid;grid-template-columns:1.5fr 1fr;gap:16px;margin-bottom:22px;">
    <div class="card" style="padding:20px;">
        <div style="font-size:13.5px;font-weight:700;color:var(--primary-dark);margin-bottom:4px;">📈 Tren Tes Siswa</div>
        <div style="font-size:11px;color:var(--text-dim);margin-bottom:16px;">7 bulan terakhir</div>
        <canvas id="trendChart"></canvas>
    </div>
    <div class="card" style="padding:20px;">
        <div style="font-size:13.5px;font-weight:700;color:var(--primary-dark);margin-bottom:14px;">🏆 Rekap Peminat Jurusan</div>
        <div style="display:flex;flex-direction:column;gap:11px;">
            <?php $__currentLoopData = $rekapJurusan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div>
                <div style="display:flex;justify-content:space-between;font-size:12px;font-weight:700;color:var(--primary-dark);margin-bottom:4px;">
                    <span><?php echo e($r->jurusan->nama ?? '?'); ?></span>
                    <span style="color:var(--text-mid);"><?php echo e($r->total); ?></span>
                </div>
                <div style="height:7px;background:var(--bg);border-radius:100px;overflow:hidden;">
                    <div style="height:100%;width:<?php echo e(round($r->total/$maxRekap*100)); ?>%;background:var(--primary);border-radius:100px;"></div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-head">
        <div class="card-title">📋 Tes Terbaru</div>
        <a href="<?php echo e(route('bk.siswa.index')); ?>" class="btn btn-outline btn-sm">Lihat Semua →</a>
    </div>
    <table>
        <thead><tr><th>Nama Siswa</th><th>Sekolah Asal</th><th>Rekomendasi</th><th>Minat Awal</th><th>Sesuai?</th><th>Tanggal</th></tr></thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $tesTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $rek    = $tes->rekomendasiTeratas?->jurusan?->nama ?? '-';
                $minat1 = $tes->minatJurusan1?->nama ?? '-';
                $sesuai = $tes->rekomendasiTeratas && $tes->rekomendasiTeratas->jurusan_id === $tes->minat_jurusan_1_id;
            ?>
            <tr>
                
                <td style="font-weight:700;color:var(--primary-dark);"><?php echo e($tes->siswa->user->nama ?? '-'); ?></td>
                <td style="font-size:11.5px;color:var(--text-dim);"><?php echo e($tes->siswa->sekolah_asal ?? '-'); ?></td>
                <td><span class="badge badge-blue"><?php echo e($rek); ?></span></td>
                <td><span class="badge badge-gray"><?php echo e($minat1); ?></span></td>
                <td>
                    <?php if($tes->rekomendasiTeratas): ?>
                        <span class="badge <?php echo e($sesuai ? 'badge-green':'badge-red'); ?>"><?php echo e($sesuai ? '✅ Sesuai':'⚠ Berbeda'); ?></span>
                    <?php else: ?> —
                    <?php endif; ?>
                </td>
                <td style="font-size:11.5px;color:var(--text-dim);"><?php echo e($tes->created_at->translatedFormat('d M Y')); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="6" style="text-align:center;color:var(--text-dim);padding:24px;">Belum ada data tes.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
new Chart(document.getElementById('trendChart'),{
    type:'line',
    data:{
        labels:<?php echo json_encode($bulanLabel); ?>,
        datasets:[{label:'Tes',data:<?php echo json_encode($bulanData); ?>,borderColor:'#1a3c6e',borderWidth:2.5,fill:true,backgroundColor:'rgba(26,60,110,.07)',tension:.4,pointBackgroundColor:'#1a3c6e',pointRadius:4}]
    },
    options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true},x:{grid:{display:false}}}}
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.bk', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SPK Jurusan SMK\4 Backup\SPK_Jurusan\SPK_Jurusan_Mapel Dipisah\resources\views/pages/bk/dashboard.blade.php ENDPATH**/ ?>
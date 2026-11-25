<?php
$kartu = [
    ['Total Barang',       $totalBarang,     'primary'],
    ['Total Kategori',     $totalKategori,   'info'],
    ['Jumlah Peminjaman',  $totalPeminjaman, 'warning'],
    ['Barang Tersedia',    $barangTersedia,  'success'],
];
?>
<div class="row g-3 mb-4">
    <?php foreach ($kartu as [$label, $nilai, $warna]): ?>
        <div class="col-6 col-lg-3">
            <div class="card border-<?= $warna ?> shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small"><?= esc($label) ?></div>
                    <div class="fs-2 fw-bold text-<?= $warna ?>"><?= (int) $nilai ?></div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<p class="text-muted">Saat ini ada <strong><?= (int) $sedangDipinjam ?></strong> transaksi yang masih berstatus dipinjam.</p>

<div class="card shadow-sm">
    <div class="card-header bg-white fw-semibold">Peminjaman Terbaru</div>
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr><th>#</th><th>Peminjam</th><th>Tgl Pinjam</th><th>Rencana Kembali</th><th>Item</th><th>Status</th></tr>
            </thead>
            <tbody>
            <?php if (! $terbaru): ?>
                <tr><td colspan="6" class="text-center text-muted py-3">Belum ada peminjaman.</td></tr>
            <?php endif; ?>
            <?php foreach ($terbaru as $r): ?>
                <tr>
                    <td><a href="<?= site_url('peminjaman/' . $r['id_peminjaman']) ?>"><?= (int) $r['id_peminjaman'] ?></a></td>
                    <td><?= esc($r['nama_peminjam']) ?></td>
                    <td><?= tgl($r['tanggal_pinjam']) ?></td>
                    <td><?= tgl($r['tanggal_rencana_kembali']) ?></td>
                    <td><?= (int) $r['total_item'] ?></td>
                    <td><?= badge($r['status']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

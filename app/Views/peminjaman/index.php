<div class="d-flex justify-content-between mb-3">
    <span class="text-muted">Total <?= count($peminjaman) ?> transaksi</span>
    <a href="<?= site_url('peminjaman/create') ?>" class="btn btn-primary">+ Catat Peminjaman</a>
</div>
<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr><th>#</th><th>Peminjam</th><th>Tgl Pinjam</th><th>Rencana Kembali</th><th class="text-end">Item</th><th>Petugas</th><th>Status</th><th></th></tr>
            </thead>
            <tbody>
            <?php if (! $peminjaman): ?>
                <tr><td colspan="8" class="text-center text-muted py-3">Belum ada transaksi peminjaman.</td></tr>
            <?php endif; ?>
            <?php foreach ($peminjaman as $r): ?>
                <tr>
                    <td><?= (int) $r['id_peminjaman'] ?></td>
                    <td><?= esc($r['nama_peminjam']) ?></td>
                    <td><?= tgl($r['tanggal_pinjam']) ?></td>
                    <td><?= tgl($r['tanggal_rencana_kembali']) ?></td>
                    <td class="text-end"><?= (int) $r['total_item'] ?></td>
                    <td><?= esc($r['petugas']) ?></td>
                    <td><?= badge($r['status']) ?></td>
                    <td class="text-end"><a href="<?= site_url('peminjaman/' . $r['id_peminjaman']) ?>" class="btn btn-sm btn-outline-primary">Detail</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

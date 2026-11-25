<div class="d-flex justify-content-between mb-3">
    <span class="text-muted">Total <?= count($pengembalian) ?> pengembalian</span>
    <a href="<?= site_url('pengembalian/create') ?>" class="btn btn-primary">+ Catat Pengembalian</a>
</div>
<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr><th>#</th><th>Peminjam</th><th>Tgl Pinjam</th><th>Rencana Kembali</th><th>Tgl Kembali</th><th>Kondisi</th><th>Keterangan</th></tr>
            </thead>
            <tbody>
            <?php if (! $pengembalian): ?>
                <tr><td colspan="7" class="text-center text-muted py-3">Belum ada pengembalian.</td></tr>
            <?php endif; ?>
            <?php foreach ($pengembalian as $r): ?>
                <tr>
                    <td><a href="<?= site_url('peminjaman/' . $r['id_peminjaman']) ?>"><?= (int) $r['id_peminjaman'] ?></a></td>
                    <td><?= esc($r['nama_peminjam']) ?></td>
                    <td><?= tgl($r['tanggal_pinjam']) ?></td>
                    <td><?= tgl($r['tanggal_rencana_kembali']) ?></td>
                    <td>
                        <?= tgl($r['tanggal_kembali']) ?>
                        <?php if ($r['tanggal_kembali'] > $r['tanggal_rencana_kembali']): ?>
                            <span class="badge text-bg-danger">Terlambat</span>
                        <?php endif; ?>
                    </td>
                    <td><?= badge($r['kondisi_barang']) ?></td>
                    <td><?= esc($r['keterangan']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

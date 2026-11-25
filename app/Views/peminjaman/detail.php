<div class="mb-3"><a href="<?= site_url('peminjaman') ?>">&laquo; Kembali ke daftar</a></div>
<div class="row g-3">
    <div class="col-lg-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold">Informasi Peminjaman</div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-5">Peminjam</dt><dd class="col-7"><?= esc($p['nama_peminjam']) ?></dd>
                    <dt class="col-5">Petugas</dt><dd class="col-7"><?= esc($p['petugas']) ?></dd>
                    <dt class="col-5">Tgl Pinjam</dt><dd class="col-7"><?= tgl($p['tanggal_pinjam']) ?></dd>
                    <dt class="col-5">Rencana Kembali</dt><dd class="col-7"><?= tgl($p['tanggal_rencana_kembali']) ?></dd>
                    <dt class="col-5">Status</dt><dd class="col-7"><?= badge($p['status']) ?></dd>
                    <dt class="col-5">Keterangan</dt><dd class="col-7"><?= esc($p['keterangan'] ?: '-') ?></dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-white fw-semibold">Barang yang Dipinjam</div>
            <table class="table mb-0">
                <thead class="table-light"><tr><th>Kode</th><th>Nama Barang</th><th class="text-end">Jumlah</th></tr></thead>
                <tbody>
                <?php foreach ($items as $it): ?>
                    <tr><td><?= esc($it['kode_barang']) ?></td><td><?= esc($it['nama_barang']) ?></td><td class="text-end"><?= (int) $it['jumlah'] ?></td></tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if ($pengembalian): ?>
            <div class="card shadow-sm border-success">
                <div class="card-header bg-white fw-semibold">Pengembalian</div>
                <div class="card-body">
                    Dikembalikan pada <strong><?= tgl($pengembalian['tanggal_kembali']) ?></strong>
                    dengan kondisi <?= badge($pengembalian['kondisi_barang']) ?>.
                    <?php if ($pengembalian['keterangan']): ?><div class="text-muted mt-1"><?= esc($pengembalian['keterangan']) ?></div><?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <a href="<?= site_url('pengembalian/create?id=' . $p['id_peminjaman']) ?>" class="btn btn-success">Catat Pengembalian</a>
        <?php endif; ?>
    </div>
</div>

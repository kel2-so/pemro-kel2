<div class="card shadow-sm mb-3 no-print">
    <div class="card-body">
        <form method="get" action="<?= site_url('laporan') ?>" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small mb-0">Kategori</label>
                <select name="id_kategori" class="form-select">
                    <option value="">Semua</option>
                    <?php foreach ($kategori as $k): ?>
                        <option value="<?= (int) $k['id_kategori'] ?>" <?= (string) $filter['id_kategori'] === (string) $k['id_kategori'] ? 'selected' : '' ?>><?= esc($k['nama_kategori']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-0">Kondisi</label>
                <select name="kondisi" class="form-select">
                    <option value="">Semua</option>
                    <?php foreach (['baik', 'rusak', 'hilang'] as $o): ?>
                        <option value="<?= $o ?>" <?= $filter['kondisi'] === $o ? 'selected' : '' ?>><?= ucfirst($o) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-0">Dari tanggal</label>
                <input type="date" name="dari" class="form-control" value="<?= esc((string) $filter['dari']) ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-0">Sampai tanggal</label>
                <input type="date" name="sampai" class="form-control" value="<?= esc((string) $filter['sampai']) ?>">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary">Terapkan</button>
                <button type="button" class="btn btn-outline-secondary" onclick="window.print()">Cetak</button>
            </div>
        </form>
        <div class="form-text">Kategori dan kondisi memfilter data barang; rentang tanggal memfilter riwayat peminjaman dan pengembalian.</div>
    </div>
</div>

<h5 class="mb-1">Laporan Inventaris Laboratorium</h5>
<p class="text-muted small">Dicetak: <?= date('d/m/Y H:i') ?></p>

<div class="row g-3 mb-3">
    <?php foreach ([['Jenis Barang', $ringkasan['jenis']], ['Total Stok', $ringkasan['stok']], ['Kondisi Rusak', $ringkasan['rusak']], ['Kondisi Hilang', $ringkasan['hilang']]] as [$l, $v]): ?>
        <div class="col-6 col-md-3"><div class="card"><div class="card-body py-2"><div class="small text-muted"><?= $l ?></div><div class="fs-4 fw-bold"><?= (int) $v ?></div></div></div></div>
    <?php endforeach; ?>
</div>

<h6 class="mt-4">1. Data Barang</h6>
<table class="table table-bordered table-sm bg-white">
    <thead class="table-light"><tr><th>Kode</th><th>Nama</th><th>Kategori</th><th class="text-end">Stok</th><th>Kondisi</th><th>Lokasi</th></tr></thead>
    <tbody>
    <?php if (! $barang): ?><tr><td colspan="6" class="text-center text-muted">Tidak ada data.</td></tr><?php endif; ?>
    <?php foreach ($barang as $b): ?>
        <tr>
            <td><?= esc($b['kode_barang']) ?></td><td><?= esc($b['nama_barang']) ?></td><td><?= esc($b['nama_kategori']) ?></td>
            <td class="text-end"><?= (int) $b['jumlah'] ?></td><td><?= esc(ucfirst($b['kondisi'])) ?></td><td><?= esc($b['lokasi']) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<h6 class="mt-4">2. Riwayat Peminjaman</h6>
<table class="table table-bordered table-sm bg-white">
    <thead class="table-light"><tr><th>#</th><th>Peminjam</th><th>Tgl Pinjam</th><th>Rencana Kembali</th><th class="text-end">Item</th><th>Status</th></tr></thead>
    <tbody>
    <?php if (! $peminjaman): ?><tr><td colspan="6" class="text-center text-muted">Tidak ada data.</td></tr><?php endif; ?>
    <?php foreach ($peminjaman as $r): ?>
        <tr>
            <td><?= (int) $r['id_peminjaman'] ?></td><td><?= esc($r['nama_peminjam']) ?></td><td><?= tgl($r['tanggal_pinjam']) ?></td>
            <td><?= tgl($r['tanggal_rencana_kembali']) ?></td><td class="text-end"><?= (int) $r['total_item'] ?></td><td><?= esc($r['status']) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<h6 class="mt-4">3. Riwayat Pengembalian</h6>
<table class="table table-bordered table-sm bg-white">
    <thead class="table-light"><tr><th>#</th><th>Peminjam</th><th>Tgl Kembali</th><th>Kondisi</th><th>Keterangan</th></tr></thead>
    <tbody>
    <?php if (! $pengembalian): ?><tr><td colspan="5" class="text-center text-muted">Tidak ada data.</td></tr><?php endif; ?>
    <?php foreach ($pengembalian as $r): ?>
        <tr>
            <td><?= (int) $r['id_peminjaman'] ?></td><td><?= esc($r['nama_peminjam']) ?></td><td><?= tgl($r['tanggal_kembali']) ?></td>
            <td><?= esc(ucfirst($r['kondisi_barang'])) ?></td><td><?= esc($r['keterangan']) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

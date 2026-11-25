<div class="card shadow-sm mb-3">
    <div class="card-body">
        <form method="get" action="<?= site_url('pencarian') ?>" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="q" class="form-control" placeholder="Cari kode atau nama barang..." value="<?= esc($filter['q']) ?>">
            </div>
            <div class="col-md-2">
                <select name="id_kategori" class="form-select">
                    <option value="">Semua kategori</option>
                    <?php foreach ($kategori as $k): ?>
                        <option value="<?= (int) $k['id_kategori'] ?>" <?= (string) $filter['id_kategori'] === (string) $k['id_kategori'] ? 'selected' : '' ?>><?= esc($k['nama_kategori']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="kondisi" class="form-select">
                    <option value="">Semua kondisi</option>
                    <?php foreach (['baik', 'rusak', 'hilang'] as $o): ?>
                        <option value="<?= $o ?>" <?= $filter['kondisi'] === $o ? 'selected' : '' ?>><?= ucfirst($o) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">Semua status</option>
                    <?php foreach (['tersedia', 'nonaktif'] as $o): ?>
                        <option value="<?= $o ?>" <?= $filter['status'] === $o ? 'selected' : '' ?>><?= ucfirst($o) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 d-grid"><button class="btn btn-primary">Cari</button></div>
        </form>
    </div>
</div>

<p class="text-muted"><?= count($hasil) ?> barang ditemukan.</p>
<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover table-sm mb-0 align-middle">
            <thead class="table-light">
                <tr><th>Kode</th><th>Nama Barang</th><th>Kategori</th><th class="text-end">Jumlah</th><th>Kondisi</th><th>Lokasi</th><th>Status</th></tr>
            </thead>
            <tbody>
            <?php if (! $hasil): ?>
                <tr><td colspan="7" class="text-center text-muted py-3">Tidak ada barang yang sesuai.</td></tr>
            <?php endif; ?>
            <?php foreach ($hasil as $b): ?>
                <tr>
                    <td><?= esc($b['kode_barang']) ?></td>
                    <td><?= esc($b['nama_barang']) ?></td>
                    <td><?= esc($b['nama_kategori']) ?></td>
                    <td class="text-end"><?= (int) $b['jumlah'] ?></td>
                    <td><?= badge($b['kondisi']) ?></td>
                    <td><?= esc($b['lokasi']) ?></td>
                    <td><?= badge($b['status']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

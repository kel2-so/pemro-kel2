<?php $admin = session()->get('role') === 'admin'; ?>
<div class="d-flex justify-content-between mb-3">
    <span class="text-muted">Total <?= count($barang) ?> jenis barang</span>
    <a href="<?= site_url('barang/create') ?>" class="btn btn-primary">+ Tambah Barang</a>
</div>
<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover table-sm mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Kode</th><th>Nama Barang</th><th>Kategori</th><th>Merek</th><th>Tahun</th>
                    <th class="text-end">Jumlah</th><th>Kondisi</th><th>Lokasi</th><th>Status</th><th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if (! $barang): ?>
                <tr><td colspan="10" class="text-center text-muted py-3">Belum ada data barang.</td></tr>
            <?php endif; ?>
            <?php foreach ($barang as $b): ?>
                <tr>
                    <td><?= esc($b['kode_barang']) ?></td>
                    <td><?= esc($b['nama_barang']) ?></td>
                    <td><?= esc($b['nama_kategori']) ?></td>
                    <td><?= esc($b['merek']) ?></td>
                    <td><?= esc($b['tahun_pembelian']) ?></td>
                    <td class="text-end"><?= (int) $b['jumlah'] ?></td>
                    <td><?= badge($b['kondisi']) ?></td>
                    <td><?= esc($b['lokasi']) ?></td>
                    <td><?= badge($b['status']) ?></td>
                    <td class="text-end text-nowrap">
                        <a href="<?= site_url('barang/edit/' . $b['id_barang']) ?>" class="btn btn-sm btn-outline-primary">Ubah</a>
                        <?php if ($admin): ?>
                            <?= form_open('barang/hapus/' . $b['id_barang'], ['class' => 'd-inline', 'onsubmit' => "return confirm('Hapus barang ini?')"]) ?>
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            <?= form_close() ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-end mb-3">
    <a href="<?= site_url('kategori/create') ?>" class="btn btn-primary">+ Tambah Kategori</a>
</div>
<div class="card shadow-sm">
    <table class="table table-hover mb-0 align-middle">
        <thead class="table-light">
            <tr><th>#</th><th>Nama Kategori</th><th>Keterangan barang</th><th class="text-end">Jumlah Barang</th><th class="text-end">Aksi</th></tr>
        </thead>
        <tbody>
        <?php if (! $kategori): ?>
            <tr><td colspan="5" class="text-center text-muted py-3">Belum ada kategori.</td></tr>
        <?php endif; ?>
        <?php foreach ($kategori as $i => $k): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= esc($k['nama_kategori']) ?></td>
                <td><?= esc($k['keterangan']) ?></td>
                <td class="text-end"><?= (int) $k['jumlah_barang'] ?></td>
                <td class="text-end text-nowrap">
                    <a href="<?= site_url('kategori/edit/' . $k['id_kategori']) ?>" class="btn btn-sm btn-outline-primary">Ubah</a>
                    <?= form_open('kategori/hapus/' . $k['id_kategori'], ['class' => 'd-inline', 'onsubmit' => "return confirm('Hapus kategori ini?')"]) ?>
                        <button class="btn btn-sm btn-outline-danger">Hapus</button>
                    <?= form_close() ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

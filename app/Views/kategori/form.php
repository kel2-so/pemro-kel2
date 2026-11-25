<div class="card shadow-sm" style="max-width: 560px;">
    <div class="card-body">
        <?= form_open($action) ?>
            <div class="mb-3">
                <label class="form-label">Nama Kategori</label>
                <input type="text" name="nama_kategori" class="form-control" maxlength="100" required value="<?= nilai('nama_kategori', $kategori) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Keterangan barang</label>
                <textarea name="keterangan" class="form-control" rows="3" maxlength="500"><?= nilai('keterangan', $kategori) ?></textarea>
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="<?= site_url('kategori') ?>" class="btn btn-secondary">Batal</a>
        <?= form_close() ?>
    </div>
</div>

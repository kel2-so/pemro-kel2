<?php
$pilih = static function (string $key, string $nilaiOpsi, ?array $row, string $default = ''): string {
    return nilai($key, $row, $default) === esc($nilaiOpsi) ? 'selected' : '';
};
?>
<div class="card shadow-sm" style="max-width: 760px;">
    <div class="card-body">
        <?= form_open($action) ?>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Kode Barang</label>
                    <input type="text" name="kode_barang" class="form-control" maxlength="30" required value="<?= nilai('kode_barang', $barang) ?>">
                </div>
                <div class="col-md-8">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" maxlength="100" required value="<?= nilai('nama_barang', $barang) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kategori</label>
                    <select name="id_kategori" class="form-select" required>
                        <option value="">-- pilih kategori --</option>
                        <?php foreach ($kategori as $k): ?>
                            <option value="<?= (int) $k['id_kategori'] ?>" <?= $pilih('id_kategori', (string) $k['id_kategori'], $barang) ?>><?= esc($k['nama_kategori']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Merek</label>
                    <input type="text" name="merek" class="form-control" maxlength="50" value="<?= nilai('merek', $barang) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tahun Pembelian</label>
                    <input type="number" name="tahun_pembelian" class="form-control" min="1990" max="2100" value="<?= nilai('tahun_pembelian', $barang) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jumlah (stok)</label>
                    <input type="number" name="jumlah" class="form-control" min="0" required value="<?= nilai('jumlah', $barang, '0') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kondisi</label>
                    <select name="kondisi" class="form-select">
                        <?php foreach (['baik', 'rusak', 'hilang'] as $o): ?>
                            <option value="<?= $o ?>" <?= $pilih('kondisi', $o, $barang, 'baik') ?>><?= ucfirst($o) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-8">
                    <label class="form-label">Lokasi</label>
                    <input type="text" name="lokasi" class="form-control" maxlength="100" value="<?= nilai('lokasi', $barang) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <?php foreach (['tersedia', 'nonaktif'] as $o): ?>
                            <option value="<?= $o ?>" <?= $pilih('status', $o, $barang, 'tersedia') ?>><?= ucfirst($o) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <button class="btn btn-primary">Simpan</button>
                <a href="<?= site_url('barang') ?>" class="btn btn-secondary">Batal</a>
            </div>
        <?= form_close() ?>
    </div>
</div>

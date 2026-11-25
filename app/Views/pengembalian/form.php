<div class="card shadow-sm mb-3" style="max-width: 760px;">
    <div class="card-body">
        <form method="get" action="<?= site_url('pengembalian/create') ?>" class="row g-2 align-items-end">
            <div class="col">
                <label class="form-label">Pilih transaksi peminjaman yang dikembalikan</label>
                <select name="id" class="form-select">
                    <option value="">-- pilih transaksi --</option>
                    <?php foreach ($aktif as $a): ?>
                        <option value="<?= (int) $a['id_peminjaman'] ?>" <?= $terpilih && (int) $terpilih['id_peminjaman'] === (int) $a['id_peminjaman'] ? 'selected' : '' ?>>
                            #<?= (int) $a['id_peminjaman'] ?> - <?= esc($a['nama_peminjam']) ?> (<?= tgl($a['tanggal_pinjam']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto"><button class="btn btn-outline-primary">Tampilkan</button></div>
        </form>
        <?php if (! $aktif): ?>
            <div class="text-muted mt-2">Tidak ada peminjaman yang masih berstatus dipinjam.</div>
        <?php endif; ?>
    </div>
</div>

<?php if ($terpilih): ?>
<div class="card shadow-sm" style="max-width: 760px;">
    <div class="card-header bg-white fw-semibold">Barang yang Dipinjam &ndash; <?= esc($terpilih['nama_peminjam']) ?></div>
    <table class="table mb-0">
        <thead class="table-light"><tr><th>Kode</th><th>Nama Barang</th><th class="text-end">Jumlah</th></tr></thead>
        <tbody>
        <?php foreach ($items as $it): ?>
            <tr><td><?= esc($it['kode_barang']) ?></td><td><?= esc($it['nama_barang']) ?></td><td class="text-end"><?= (int) $it['jumlah'] ?></td></tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="card-body border-top">
        <?= form_open('pengembalian/store') ?>
            <input type="hidden" name="id_peminjaman" value="<?= (int) $terpilih['id_peminjaman'] ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" class="form-control" required value="<?= nilai('tanggal_kembali', null, date('Y-m-d')) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kondisi Barang</label>
                    <select name="kondisi_barang" class="form-select">
                        <?php foreach (['baik', 'rusak', 'hilang'] as $o): ?>
                            <option value="<?= $o ?>" <?= nilai('kondisi_barang') === $o ? 'selected' : '' ?>><?= ucfirst($o) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="2" maxlength="500"><?= nilai('keterangan') ?></textarea>
                </div>
            </div>
            <div class="form-text mt-2">Barang berkondisi baik dan rusak dikembalikan ke stok; barang hilang tidak menambah stok. Kondisi barang diperbarui bila rusak atau hilang.</div>
            <div class="mt-3">
                <button class="btn btn-success">Simpan Pengembalian</button>
                <a href="<?= site_url('pengembalian') ?>" class="btn btn-secondary">Batal</a>
            </div>
        <?= form_close() ?>
    </div>
</div>
<?php endif; ?>

<div class="card shadow-sm" style="max-width: 820px;">
    <div class="card-body">
        <?php if (! $barang): ?>
            <div class="alert alert-warning mb-0">Tidak ada barang yang dapat dipinjam (stok kosong, kondisi tidak baik, atau nonaktif).</div>
        <?php else: ?>
        <?= form_open('peminjaman/store') ?>
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label">Nama Peminjam</label>
                    <input type="text" name="nama_peminjam" class="form-control" maxlength="100" required value="<?= nilai('nama_peminjam') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" class="form-control" required value="<?= nilai('tanggal_pinjam', null, date('Y-m-d')) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal Rencana Kembali</label>
                    <input type="date" name="tanggal_rencana_kembali" class="form-control" required value="<?= nilai('tanggal_rencana_kembali', null, date('Y-m-d', strtotime('+7 days'))) ?>">
                </div>
            </div>

            <hr>
            <label class="form-label fw-semibold">Barang yang Dipinjam</label>
            <div id="rows"></div>
            <button type="button" id="tambah" class="btn btn-outline-primary btn-sm mb-3">+ Tambah barang</button>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2" maxlength="500"><?= nilai('keterangan') ?></textarea>
            </div>
            <button class="btn btn-primary">Simpan Peminjaman</button>
            <a href="<?= site_url('peminjaman') ?>" class="btn btn-secondary">Batal</a>
        <?= form_close() ?>

        <template id="tpl">
            <div class="row g-2 mb-2 baris">
                <div class="col-8">
                    <select name="id_barang[]" class="form-select">
                        <option value="">-- pilih barang --</option>
                        <?php foreach ($barang as $b): ?>
                            <option value="<?= (int) $b['id_barang'] ?>"><?= esc($b['kode_barang'] . ' - ' . $b['nama_barang']) ?> (stok: <?= (int) $b['jumlah'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-3"><input type="number" name="jumlah[]" class="form-control" min="1" value="1"></div>
                <div class="col-1"><button type="button" class="btn btn-outline-danger hapus">&times;</button></div>
            </div>
        </template>
        <script>
            (function () {
                var rows = document.getElementById('rows');
                var tpl = document.getElementById('tpl');
                function tambah() { rows.appendChild(tpl.content.cloneNode(true)); }
                document.getElementById('tambah').addEventListener('click', tambah);
                rows.addEventListener('click', function (e) {
                    if (e.target.classList.contains('hapus')) {
                        var baris = e.target.closest('.baris');
                        if (rows.querySelectorAll('.baris').length > 1) { baris.remove(); }
                    }
                });
                tambah();
            })();
        </script>
        <?php endif; ?>
    </div>
</div>

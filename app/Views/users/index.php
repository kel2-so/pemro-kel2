<div class="d-flex justify-content-end mb-3">
    <a href="<?= site_url('users/create') ?>" class="btn btn-primary">+ Tambah Pengguna</a>
</div>
<div class="card shadow-sm">
    <table class="table table-hover mb-0 align-middle">
        <thead class="table-light"><tr><th>#</th><th>Nama</th><th>Username</th><th>Role</th><th class="text-end">Aksi</th></tr></thead>
        <tbody>
        <?php foreach ($users as $i => $u): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= esc($u['nama']) ?></td>
                <td><?= esc($u['username']) ?></td>
                <td><span class="badge text-bg-<?= $u['role'] === 'admin' ? 'primary' : 'secondary' ?>"><?= esc(ucfirst($u['role'])) ?></span></td>
                <td class="text-end">
                    <a href="<?= site_url('users/edit/' . $u['id_user']) ?>" class="btn btn-sm btn-outline-warning">Edit</a>
                    <?php if ((int) $u['id_user'] !== (int) session()->get('id_user')): ?>
                        <?= form_open('users/hapus/' . $u['id_user'], ['class' => 'd-inline', 'onsubmit' => "return confirm('Hapus pengguna ini?')"]) ?>
                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                        <?= form_close() ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
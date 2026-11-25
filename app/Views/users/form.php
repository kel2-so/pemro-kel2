<?php
$isEdit = isset($user);
$action = $isEdit ? 'users/update/' . $user['id_user'] : 'users/store';
?>
<div class="card shadow-sm" style="max-width: 560px;">
    <div class="card-body">
        <?= form_open($action) ?>
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" maxlength="100" required
                       value="<?= esc(nilai('nama') ?: ($user['nama'] ?? '')) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" maxlength="50" required
                       value="<?= esc(nilai('username') ?: ($user['username'] ?? '')) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">
                    Password <?= $isEdit ? '(kosongkan jika tidak diubah)' : '(min. 6 karakter)' ?>
                </label>
                <input type="password" name="password" class="form-control" minlength="6" <?= $isEdit ? '' : 'required' ?>>
            </div>
            <div class="mb-3">
                <label class="form-label">Role</label>
                <?php $selectedRole = nilai('role') ?: ($user['role'] ?? 'laboran'); ?>
                <select name="role" class="form-select">
                    <option value="laboran" <?= $selectedRole === 'laboran' ? 'selected' : '' ?>>Laboran</option>
                    <option value="admin" <?= $selectedRole === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="<?= site_url('users') ?>" class="btn btn-secondary">Batal</a>
        <?= form_close() ?>
    </div>
</div>
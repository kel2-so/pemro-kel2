<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Inventaris Laboratorium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background: linear-gradient(
            135deg,
            #1f2d3d 0%,
            #263f59 55%,
            #0d6efd 140%
        );
    }

    .login-card {
        width: 390px;
        max-width: calc(100vw - 32px);
        border: 0;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 18px 50px rgba(0,0,0,.2) !important;
    }

    .login-brand {
        width: 76px;
        height: 76px;
        object-fit: contain;
        padding: 7px;
        background: #eff6ff;
        border-radius: 20px;
        margin-bottom: 1rem;
    }

    .login-title {
        color: #203247;
        font-weight: 750;
        letter-spacing: -.3px;
    }

    .login-subtitle {
        color: #718096;
    }

    .login-card .form-label {
        font-weight: 600;
        color: #34465a;
    }

    .login-card .form-control {
        border-radius: .55rem;
        padding: .65rem .75rem;
    }

    .login-card .btn {
        border-radius: .55rem;
        padding: .68rem;
        font-weight: 650;
    }
</style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="card login-card shadow">
    <div class="card-body p-4 p-md-5">
        <div class="text-center">
            <img
                class="login-brand"
                src="<?= base_url('assets/logo-lab.svg') ?>"
                alt="Logo Inventaris Laboratorium"
            >

            <h4 class="text-center mb-1 login-title">
                Inventaris Laboratorium
            </h4>

            <p class="text-center small mb-4 login-subtitle">
                Silakan login untuk melanjutkan
            </p>
        </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger py-2"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success py-2"><?= esc(session()->getFlashdata('success')) ?></div>
            <?php endif; ?>

            <?= form_open('login') ?>
                <div class="mb-3">
                    <label class="form-label" for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username"
                           value="<?= nilai('username') ?>" autofocus required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Masuk</button>
            <?= form_close() ?>
        </div>
    </div>
</body>
</html>

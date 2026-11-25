<?php
$role   = session()->get('role');
$active = $active ?? '';

$menu = [
    ['dashboard',    'Dashboard',    'dashboard',    ['admin', 'laboran']],
    ['barang',       'Data Barang',  'barang',       ['admin', 'laboran']],
    ['kategori',     'Kategori',     'kategori',     ['admin']],
    ['peminjaman',   'Peminjaman',   'peminjaman',   ['admin', 'laboran']],
    ['pengembalian', 'Pengembalian', 'pengembalian', ['admin', 'laboran']],
    ['pencarian',    'Pencarian',    'pencarian',    ['admin', 'laboran']],
    ['laporan',      'Laporan',      'laporan',      ['admin', 'laboran']],
    ['users',        'Pengguna',     'users',        ['admin']],
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= esc($title ?? 'Inventaris Lab') ?> | Inventaris Laboratorium</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --lab-navy: #1f2d3d;
            --lab-blue: #0d6efd;
            --lab-bg: #f4f6f9;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: var(--lab-bg);
            color: #273444;
            font-size: .94rem;
            margin: 0;
        }

        /* SIDEBAR */
        .sidebar {
            width: 238px;
            min-height: 100vh;
            flex: 0 0 238px;
            background: var(--lab-navy);
            box-shadow: 3px 0 14px rgba(20,35,50,.08);
        }

        .sidebar .brand {
            display: flex;
            align-items: center;
            gap: .7rem;
            color: #fff;
            font-weight: 700;
            font-size: 1.02rem;
            padding: 1.1rem 1.15rem;
            border-bottom: 1px solid #33475b;
        }

        .sidebar .brand img {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: #fff;
            object-fit: contain;
        }

        .sidebar a.nav-link {
            color: #c2cdd8;
            margin: .15rem .65rem;
            padding: .72rem .85rem;
            border-radius: .55rem;
            transition: background .18s ease, color .18s ease;
        }

        .sidebar a.nav-link:hover {
            background: #2b3e52;
            color: #fff;
        }

        .sidebar a.nav-link.active {
            background: var(--lab-blue);
            color: #fff;
            box-shadow: 0 4px 10px rgba(13,110,253,.22);
        }

        /* CONTENT */
        .content {
            flex: 1;
            min-width: 0;
        }

        .topbar {
            min-height: 62px;
            box-shadow: 0 2px 8px rgba(20,35,50,.035);
        }

        .topbar h5 {
            font-weight: 650;
            color: #253447;
        }

        /* INFORMASI PENGGUNA */
        .user-chip {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            padding: .38rem .7rem;
            border-radius: 2rem;
            background: #f1f5f9;
            color: #425466;
        }

        /* TOMBOL LOGOUT */
        .logout-btn {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-weight: 600;
            border-radius: .5rem;
            padding: .42rem .75rem;
            text-decoration: none;
            color: #dc3545;
            border: 1px solid #f1b8be;
            background: #fff;
            transition: all .18s ease;
        }

        .logout-btn:hover {
            color: #fff;
            background: #dc3545;
            border-color: #dc3545;
        }

        /* TOMBOL UMUM */
        .btn {
            border-radius: .5rem;
            font-weight: 600;
            padding: .48rem .85rem;
            transition: all .16s ease;
        }

        .btn-sm {
            padding: .32rem .62rem;
            font-size: .82rem;
        }

        .btn-primary,
        .btn-success,
        .btn-danger,
        .btn-secondary {
            box-shadow: 0 2px 5px rgba(30,50,70,.08);
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn:focus-visible,
        a:focus-visible {
            outline: 3px solid rgba(13,110,253,.25);
            outline-offset: 2px;
        }

        /* CARD */
        .card {
            border: 1px solid #e7ebf0;
            border-radius: .8rem;
            box-shadow: 0 3px 14px rgba(31,45,61,.045);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #edf0f3;
            font-weight: 650;
        }

        /* TABEL */
        .table {
            --bs-table-bg: transparent;
        }

        .table thead th {
            background: #f1f5f9;
            color: #425466;
            font-size: .82rem;
            font-weight: 700;
            white-space: nowrap;
            border-bottom: 1px solid #e2e8f0;
        }

        .table > :not(caption) > * > * {
            padding: .72rem .75rem;
            vertical-align: middle;
        }

        /* FORM */
        .form-control,
        .form-select {
            border-radius: .5rem;
            border-color: #d9e0e8;
            padding: .55rem .7rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 .2rem rgba(13,110,253,.12);
        }

        /* TAMPILAN HP */
        @media (max-width: 767.98px) {

            .sidebar {
                width: 180px;
                flex: 0 0 180px;
            }

            .sidebar .brand {
                padding: .9rem .7rem;
                font-size: .9rem;
            }

            .sidebar a.nav-link {
                font-size: .85rem;
                padding: .65rem .7rem;
            }

            .topbar {
                padding-left: .75rem !important;
                padding-right: .75rem !important;
            }

            .topbar h5 {
                font-size: .95rem;
            }

            .user-chip {
                display: none;
            }

            .logout-btn {
                font-size: .8rem;
                padding: .35rem .55rem;
            }

            main {
                padding: 1rem !important;
            }
        }

        /* CETAK LAPORAN */
        @media print {
            .sidebar,
            .topbar,
            .no-print {
                display: none !important;
            }

            body {
                background: #fff;
            }
        }
    </style>
</head>

<body>

<div class="d-flex">

    <!-- SIDEBAR -->
    <aside class="sidebar d-flex flex-column">

        <div class="brand">
            <img
                src="<?= base_url('assets/logo-lab.svg') ?>"
                alt="Logo Inventaris Lab"
            >
            <span>Inventaris Lab</span>
        </div>

        <nav class="nav flex-column mt-2">

            <?php foreach ($menu as [$key, $label, $url, $roles]): ?>

                <?php if (in_array($role, $roles, true)): ?>

                    <a
                        class="nav-link <?= $active === $key ? 'active' : '' ?>"
                        href="<?= site_url($url) ?>"
                    >
                        <?= esc($label) ?>
                    </a>

                <?php endif; ?>

            <?php endforeach; ?>

        </nav>

    </aside>

    <!-- KONTEN UTAMA -->
    <div class="content">

        <!-- TOPBAR -->
        <div class="topbar bg-white border-bottom px-4 py-2 d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                <?= esc($title ?? '') ?>
            </h5>

            <div class="d-flex align-items-center gap-2">

                <span class="user-chip small">
                    <span aria-hidden="true">&#128100;</span>

                    <?= esc(session()->get('nama')) ?>

                    <span class="text-capitalize">
                        (<?= esc($role) ?>)
                    </span>
                </span>

                <a
                    class="logout-btn"
                    href="<?= site_url('logout') ?>"
                    aria-label="Keluar dari aplikasi"
                >
                    <span aria-hidden="true">&#10162;</span>
                    Logout
                </a>

            </div>

        </div>

        <!-- MAIN CONTENT -->
        <main class="p-4">

            <?php if (session()->getFlashdata('success')): ?>

                <div class="alert alert-success no-print">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>

            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>

                <div class="alert alert-danger no-print">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>

            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>

                <div class="alert alert-danger no-print">

                    <ul class="mb-0">

                        <?php foreach ((array) session()->getFlashdata('errors') as $e): ?>

                            <li><?= esc($e) ?></li>

                        <?php endforeach; ?>

                    </ul>

                </div>

            <?php endif; ?>

            <?= $content ?>

        </main>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ---- Publik ----
$routes->get('login', 'AuthController::index');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

// ---- Admin dan Laboran ----
$routes->group('', ['filter' => 'auth:admin,laboran'], static function ($routes) {
    $routes->get('/', 'DashboardController::index');
    $routes->get('dashboard', 'DashboardController::index');

    // Barang (hapus khusus admin, lihat grup di bawah)
    $routes->get('barang', 'BarangController::index');
    $routes->get('barang/create', 'BarangController::create');
    $routes->post('barang/store', 'BarangController::store');
    $routes->get('barang/edit/(:num)', 'BarangController::edit/$1');
    $routes->post('barang/update/(:num)', 'BarangController::update/$1');

    // Peminjaman
    $routes->get('peminjaman', 'PeminjamanController::index');
    $routes->get('peminjaman/create', 'PeminjamanController::create');
    $routes->post('peminjaman/store', 'PeminjamanController::store');
    $routes->get('peminjaman/(:num)', 'PeminjamanController::show/$1');

    // Pengembalian
    $routes->get('pengembalian', 'PengembalianController::index');
    $routes->get('pengembalian/create', 'PengembalianController::create');
    $routes->post('pengembalian/store', 'PengembalianController::store');

    // Pencarian dan laporan
    $routes->get('pencarian', 'PencarianController::index');
    $routes->get('laporan', 'LaporanController::index');
});

// ---- Khusus Admin ----
$routes->group('', ['filter' => 'auth:admin'], static function ($routes) {
    $routes->post('barang/hapus/(:num)', 'BarangController::delete/$1');

    $routes->get('kategori', 'KategoriController::index');
    $routes->get('kategori/create', 'KategoriController::create');
    $routes->post('kategori/store', 'KategoriController::store');
    $routes->get('kategori/edit/(:num)', 'KategoriController::edit/$1');
    $routes->post('kategori/update/(:num)', 'KategoriController::update/$1');
    $routes->post('kategori/hapus/(:num)', 'KategoriController::delete/$1');

    $routes->get('users', 'UserController::index');
    $routes->get('users/create', 'UserController::create');
    $routes->post('users/store', 'UserController::store');
    $routes->get('users/edit/(:num)', 'UserController::edit/$1');
    $routes->post('users/update/(:num)', 'UserController::update/$1');
    $routes->post('users/hapus/(:num)', 'UserController::delete/$1');
});
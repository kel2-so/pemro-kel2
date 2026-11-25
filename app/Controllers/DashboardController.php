<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use App\Models\PeminjamanModel;

class DashboardController extends AppController
{
    public function index()
    {
        $barang     = new BarangModel();
        $kategori   = new KategoriModel();
        $peminjaman = new PeminjamanModel();

        return $this->render('dashboard/index', [
            'title'           => 'Dashboard',
            'active'          => 'dashboard',
            'totalBarang'     => $barang->countAllResults(),
            'totalKategori'   => $kategori->countAllResults(),
            'totalPeminjaman' => $peminjaman->countAllResults(),
            'sedangDipinjam'  => $peminjaman->where('status', 'Dipinjam')->countAllResults(),
            'barangTersedia'  => $barang->totalTersedia(),
            'terbaru'         => $peminjaman->daftar([], 5),
        ]);
    }
}

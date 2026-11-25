<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use App\Models\PeminjamanModel;
use App\Models\PengembalianModel;

class LaporanController extends AppController
{
    public function index()
    {
        $filter = [
            'id_kategori' => $this->request->getGet('id_kategori'),
            'kondisi'     => $this->request->getGet('kondisi'),
            'dari'        => $this->request->getGet('dari'),
            'sampai'      => $this->request->getGet('sampai'),
        ];

        $barang = (new BarangModel())->search($filter);

        $ringkasan = [
            'jenis' => count($barang),
            'stok'  => array_sum(array_column($barang, 'jumlah')),
            'rusak' => count(array_filter($barang, static fn ($b) => $b['kondisi'] === 'rusak')),
            'hilang' => count(array_filter($barang, static fn ($b) => $b['kondisi'] === 'hilang')),
        ];

        return $this->render('laporan/index', [
            'title'        => 'Laporan Inventaris',
            'active'       => 'laporan',
            'filter'       => $filter,
            'kategori'     => (new KategoriModel())->orderBy('nama_kategori')->findAll(),
            'barang'       => $barang,
            'ringkasan'    => $ringkasan,
            'peminjaman'   => (new PeminjamanModel())->daftar($filter),
            'pengembalian' => (new PengembalianModel())->riwayat($filter),
        ]);
    }
}

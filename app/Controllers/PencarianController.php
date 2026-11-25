<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;

class PencarianController extends AppController
{
    public function index()
    {
        $filter = [
            'q'           => trim((string) $this->request->getGet('q')),
            'id_kategori' => $this->request->getGet('id_kategori'),
            'kondisi'     => $this->request->getGet('kondisi'),
            'status'      => $this->request->getGet('status'),
        ];

        return $this->render('pencarian/index', [
            'title'    => 'Pencarian Barang',
            'active'   => 'pencarian',
            'filter'   => $filter,
            'kategori' => (new KategoriModel())->orderBy('nama_kategori')->findAll(),
            'hasil'    => (new BarangModel())->search($filter),
        ]);
    }
}
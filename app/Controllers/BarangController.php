<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\DetailPeminjamanModel;
use App\Models\KategoriModel;

class BarangController extends AppController
{
    private function rules(?int $id = null): array
    {
        $unik = $id
            ? "is_unique[barang.kode_barang,id_barang,{$id}]"
            : 'is_unique[barang.kode_barang]';

        return [
            'kode_barang'     => "required|max_length[30]|{$unik}",
            'nama_barang'     => 'required|max_length[100]',
            'id_kategori'     => 'required|is_natural_no_zero',
            'merek'           => 'permit_empty|max_length[50]',
            'tahun_pembelian' => 'permit_empty|exact_length[4]|is_natural',
            'jumlah'          => 'required|is_natural',
            'kondisi'         => 'required|in_list[baik,rusak,hilang]',
            'lokasi'          => 'permit_empty|max_length[100]',
            'status'          => 'required|in_list[tersedia,nonaktif]',
        ];
    }

    private function pesan(): array
    {
        return [
            'kode_barang' => ['is_unique' => 'Kode barang sudah digunakan barang lain.'],
        ];
    }

    private function dataForm(): array
    {
        $post = $this->request->getPost();

        return [
            'kode_barang'     => trim($post['kode_barang'] ?? ''),
            'nama_barang'     => trim($post['nama_barang'] ?? ''),
            'id_kategori'     => (int) ($post['id_kategori'] ?? 0),
            'merek'           => trim($post['merek'] ?? ''),
            'tahun_pembelian' => ($post['tahun_pembelian'] ?? '') !== '' ? (int) $post['tahun_pembelian'] : null,
            'jumlah'          => (int) ($post['jumlah'] ?? 0),
            'kondisi'         => $post['kondisi'] ?? 'baik',
            'lokasi'          => trim($post['lokasi'] ?? ''),
            'status'          => $post['status'] ?? 'tersedia',
        ];
    }

    public function index()
    {
        return $this->render('barang/index', [
            'title'  => 'Data Barang',
            'active' => 'barang',
            'barang' => (new BarangModel())->search(),
        ]);
    }

    public function create()
    {
        return $this->render('barang/form', [
            'title'    => 'Tambah Barang',
            'active'   => 'barang',
            'barang'   => null,
            'action'   => site_url('barang/store'),
            'kategori' => (new KategoriModel())->orderBy('nama_kategori')->findAll(),
        ]);
    }

    public function store()
    {
        if (! $this->validate($this->rules(), $this->pesan())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new BarangModel())->insert($this->dataForm());

        return redirect()->to('/barang')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $barang = (new BarangModel())->find($id);
        if (! $barang) {
            return redirect()->to('/barang')->with('error', 'Barang tidak ditemukan.');
        }

        return $this->render('barang/form', [
            'title'    => 'Ubah Barang',
            'active'   => 'barang',
            'barang'   => $barang,
            'action'   => site_url('barang/update/' . $id),
            'kategori' => (new KategoriModel())->orderBy('nama_kategori')->findAll(),
        ]);
    }

    public function update(int $id)
    {
        $model = new BarangModel();
        if (! $model->find($id)) {
            return redirect()->to('/barang')->with('error', 'Barang tidak ditemukan.');
        }
        if (! $this->validate($this->rules($id), $this->pesan())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->update($id, $this->dataForm());

        return redirect()->to('/barang')->with('success', 'Data barang berhasil diubah.');
    }

    public function delete(int $id)
    {
        $model = new BarangModel();
        if (! $model->find($id)) {
            return redirect()->to('/barang')->with('error', 'Barang tidak ditemukan.');
        }
        if ((new DetailPeminjamanModel())->where('id_barang', $id)->countAllResults() > 0) {
            return redirect()->to('/barang')->with('error', 'Barang tidak dapat dihapus karena sudah memiliki riwayat peminjaman. Ubah statusnya menjadi nonaktif.');
        }

        $model->delete($id);

        return redirect()->to('/barang')->with('success', 'Barang berhasil dihapus.');
    }
}

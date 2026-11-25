<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;

class KategoriController extends AppController
{
    private function rules(?int $id = null): array
    {
        $unik = $id
            ? "is_unique[kategori.nama_kategori,id_kategori,{$id}]"
            : 'is_unique[kategori.nama_kategori]';

        return [
            'nama_kategori' => "required|max_length[100]|{$unik}",
            'keterangan'    => 'permit_empty|max_length[500]',
        ];
    }

    private function pesan(): array
    {
        return ['nama_kategori' => ['is_unique' => 'Nama kategori sudah ada.']];
    }

    public function index()
    {
        $rows = (new KategoriModel())
            ->select('kategori.*, (SELECT COUNT(*) FROM barang WHERE barang.id_kategori = kategori.id_kategori) AS jumlah_barang', false)
            ->orderBy('nama_kategori')
            ->findAll();

        return $this->render('kategori/index', [
            'title'    => 'Kategori Barang',
            'active'   => 'kategori',
            'kategori' => $rows,
        ]);
    }

    public function create()
    {
        return $this->render('kategori/form', [
            'title' => 'Tambah Kategori', 'active' => 'kategori',
            'kategori' => null, 'action' => site_url('kategori/store'),
        ]);
    }

    public function store()
    {
        if (! $this->validate($this->rules(), $this->pesan())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new KategoriModel())->insert([
            'nama_kategori' => trim($this->request->getPost('nama_kategori')),
            'keterangan'    => trim((string) $this->request->getPost('keterangan')),
        ]);

        return redirect()->to('/kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $kategori = (new KategoriModel())->find($id);
        if (! $kategori) {
            return redirect()->to('/kategori')->with('error', 'Kategori tidak ditemukan.');
        }

        return $this->render('kategori/form', [
            'title' => 'Ubah Kategori', 'active' => 'kategori',
            'kategori' => $kategori, 'action' => site_url('kategori/update/' . $id),
        ]);
    }

    public function update(int $id)
    {
        $model = new KategoriModel();
        if (! $model->find($id)) {
            return redirect()->to('/kategori')->with('error', 'Kategori tidak ditemukan.');
        }
        if (! $this->validate($this->rules($id), $this->pesan())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->update($id, [
            'nama_kategori' => trim($this->request->getPost('nama_kategori')),
            'keterangan'    => trim((string) $this->request->getPost('keterangan')),
        ]);

        return redirect()->to('/kategori')->with('success', 'Kategori berhasil diubah.');
    }

    public function delete(int $id)
    {
        if ((new BarangModel())->where('id_kategori', $id)->countAllResults() > 0) {
            return redirect()->to('/kategori')->with('error', 'Kategori masih dipakai oleh data barang sehingga tidak dapat dihapus.');
        }

        (new KategoriModel())->delete($id);

        return redirect()->to('/kategori')->with('success', 'Kategori berhasil dihapus.');
    }
}

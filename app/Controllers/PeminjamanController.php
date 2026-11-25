<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\DetailPeminjamanModel;
use App\Models\PeminjamanModel;
use App\Models\PengembalianModel;

class PeminjamanController extends AppController
{
    public function index()
    {
        return $this->render('peminjaman/index', [
            'title'      => 'Peminjaman Barang',
            'active'     => 'peminjaman',
            'peminjaman' => (new PeminjamanModel())->daftar(),
        ]);
    }

    public function create()
    {
        return $this->render('peminjaman/form', [
            'title'  => 'Catat Peminjaman',
            'active' => 'peminjaman',
            'barang' => (new BarangModel())->dapatDipinjam(),
        ]);
    }

    public function store()
    {
        $rules = [
            'nama_peminjam'           => 'required|max_length[100]',
            'tanggal_pinjam'          => 'required|valid_date[Y-m-d]',
            'tanggal_rencana_kembali' => 'required|valid_date[Y-m-d]',
            'keterangan'              => 'permit_empty|max_length[500]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $errors     = [];
        $tglPinjam  = $this->request->getPost('tanggal_pinjam');
        $tglKembali = $this->request->getPost('tanggal_rencana_kembali');
        if ($tglKembali < $tglPinjam) {
            $errors[] = 'Tanggal rencana kembali tidak boleh sebelum tanggal pinjam.';
        }

        // Gabungkan baris barang (jika barang yang sama dipilih dua kali, jumlahnya dijumlahkan).
        $ids   = (array) $this->request->getPost('id_barang');
        $qtys  = (array) $this->request->getPost('jumlah');
        $items = [];
        foreach ($ids as $i => $id) {
            $id = (int) $id;
            $q  = (int) ($qtys[$i] ?? 0);
            if ($id < 1) {
                continue; // baris kosong
            }
            if ($q < 1) {
                $errors[] = 'Jumlah barang yang dipinjam minimal 1.';
                continue;
            }
            $items[$id] = ($items[$id] ?? 0) + $q;
        }
        if (! $items) {
            $errors[] = 'Pilih minimal satu barang yang dipinjam.';
        }

        // Validasi stok: jumlah pinjam tidak boleh melebihi stok tersedia.
        $barangModel = new BarangModel();
        foreach ($items as $id => $q) {
            $b = $barangModel->find($id);
            if (! $b || $b['kondisi'] !== 'baik' || $b['status'] !== 'tersedia') {
                $errors[] = "Barang dengan ID {$id} tidak dapat dipinjam.";
                continue;
            }
            if ($q > (int) $b['jumlah']) {
                $errors[] = "Jumlah {$b['nama_barang']} melebihi stok tersedia ({$b['jumlah']}).";
            }
        }
        if ($errors) {
            return redirect()->back()->withInput()->with('errors', array_values(array_unique($errors)));
        }

        // Simpan transaksi, rincian, dan pengurangan stok dalam satu transaksi database.
        $db = db_connect();
        $db->transStart();

        $idPinjam = (new PeminjamanModel())->insert([
            'id_user'                 => (int) session()->get('id_user'),
            'nama_peminjam'           => trim($this->request->getPost('nama_peminjam')),
            'tanggal_pinjam'          => $tglPinjam,
            'tanggal_rencana_kembali' => $tglKembali,
            'status'                  => 'Dipinjam',
            'keterangan'              => trim((string) $this->request->getPost('keterangan')),
        ], true);

        $detail = new DetailPeminjamanModel();
        foreach ($items as $id => $q) {
            $detail->insert(['id_peminjaman' => $idPinjam, 'id_barang' => $id, 'jumlah' => $q]);
            $db->table('barang')->set('jumlah', 'jumlah - ' . (int) $q, false)->where('id_barang', $id)->update();
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan transaksi peminjaman.');
        }

        return redirect()->to('/peminjaman/' . $idPinjam)->with('success', 'Peminjaman berhasil dicatat dan stok diperbarui.');
    }

    public function show(int $id)
    {
        $p = (new PeminjamanModel())->satu($id);
        if (! $p) {
            return redirect()->to('/peminjaman')->with('error', 'Data peminjaman tidak ditemukan.');
        }

        return $this->render('peminjaman/detail', [
            'title'       => 'Detail Peminjaman #' . $id,
            'active'      => 'peminjaman',
            'p'           => $p,
            'items'       => (new DetailPeminjamanModel())->items($id),
            'pengembalian' => (new PengembalianModel())->where('id_peminjaman', $id)->first(),
        ]);
    }
}

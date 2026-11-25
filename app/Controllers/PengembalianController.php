<?php

namespace App\Controllers;

use App\Models\DetailPeminjamanModel;
use App\Models\PeminjamanModel;
use App\Models\PengembalianModel;

class PengembalianController extends AppController
{
    public function index()
    {
        return $this->render('pengembalian/index', [
            'title'       => 'Riwayat Pengembalian',
            'active'      => 'pengembalian',
            'pengembalian' => (new PengembalianModel())->riwayat(),
        ]);
    }

    public function create()
    {
        $peminjaman = new PeminjamanModel();
        $dipilih    = (int) $this->request->getGet('id');

        $terpilih = null;
        $items    = [];
        if ($dipilih > 0) {
            $terpilih = $peminjaman->where('id_peminjaman', $dipilih)->where('status', 'Dipinjam')->first();
            if ($terpilih) {
                $items = (new DetailPeminjamanModel())->items($dipilih);
            }
        }

        return $this->render('pengembalian/form', [
            'title'    => 'Catat Pengembalian',
            'active'   => 'pengembalian',
            'aktif'    => $peminjaman->where('status', 'Dipinjam')->orderBy('id_peminjaman', 'DESC')->findAll(),
            'terpilih' => $terpilih,
            'items'    => $items,
        ]);
    }

    public function store()
    {
        $rules = [
            'id_peminjaman'  => 'required|is_natural_no_zero',
            'tanggal_kembali' => 'required|valid_date[Y-m-d]',
            'kondisi_barang' => 'required|in_list[baik,rusak,hilang]',
            'keterangan'     => 'permit_empty|max_length[500]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id      = (int) $this->request->getPost('id_peminjaman');
        $kondisi = $this->request->getPost('kondisi_barang');
        $tgl     = $this->request->getPost('tanggal_kembali');

        $peminjaman = new PeminjamanModel();
        $p = $peminjaman->find($id);
        if (! $p || $p['status'] !== 'Dipinjam') {
            return redirect()->to('/pengembalian/create')->with('error', 'Transaksi tidak ditemukan atau sudah dikembalikan.');
        }
        if ($tgl < $p['tanggal_pinjam']) {
            return redirect()->back()->withInput()->with('error', 'Tanggal kembali tidak boleh sebelum tanggal pinjam.');
        }

        $details = (new DetailPeminjamanModel())->where('id_peminjaman', $id)->findAll();

        $db = db_connect();
        $db->transStart();

        (new PengembalianModel())->insert([
            'id_peminjaman'   => $id,
            'tanggal_kembali' => $tgl,
            'kondisi_barang'  => $kondisi,
            'keterangan'      => trim((string) $this->request->getPost('keterangan')),
        ]);

        foreach ($details as $d) {
            // Barang yang hilang tidak menambah stok; baik dan rusak kembali ke stok.
            if ($kondisi !== 'hilang') {
                $db->table('barang')->set('jumlah', 'jumlah + ' . (int) $d['jumlah'], false)
                    ->where('id_barang', $d['id_barang'])->update();
            }
            // Kondisi barang diperbarui bila tidak baik.
            if ($kondisi !== 'baik') {
                $db->table('barang')->where('id_barang', $d['id_barang'])->update(['kondisi' => $kondisi]);
            }
        }

        $peminjaman->update($id, ['status' => 'Dikembalikan']);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan pengembalian.');
        }

        return redirect()->to('/pengembalian')->with('success', 'Pengembalian berhasil dicatat. Status, stok, dan kondisi barang diperbarui.');
    }
}

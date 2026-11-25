<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\UserModel;

class UserController extends AppController
{
    public function index()
    {
        return $this->render('users/index', [
            'title'  => 'Pengguna',
            'active' => 'users',
            'users'  => (new UserModel())->orderBy('nama')->findAll(),
        ]);
    }

    public function create()
    {
        return $this->render('users/form', [
            'title'  => 'Tambah Pengguna',
            'active' => 'users',
        ]);
    }

    public function store()
    {
        $rules = [
            'nama'     => 'required|max_length[100]',
            'username' => 'required|alpha_numeric|min_length[4]|max_length[50]|is_unique[users.username]',
            'password' => 'required|min_length[6]',
            'role'     => 'required|in_list[admin,laboran]',
        ];
        $pesan = ['username' => ['is_unique' => 'Username sudah digunakan.']];

        if (! $this->validate($rules, $pesan)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new UserModel())->insert([
            'nama'     => trim($this->request->getPost('nama')),
            'username' => $this->request->getPost('username'),
            'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
        ]);

        return redirect()->to('/users')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $user = (new UserModel())->find($id);
        if (! $user) {
            return redirect()->to('/users')->with('error', 'Pengguna tidak ditemukan.');
        }

        return $this->render('users/form', [
            'title'  => 'Edit Pengguna',
            'active' => 'users',
            'user'   => $user,
        ]);
    }

    public function update(int $id)
    {
        $userModel = new UserModel();
        $user      = $userModel->find($id);
        if (! $user) {
            return redirect()->to('/users')->with('error', 'Pengguna tidak ditemukan.');
        }

        $rules = [
            'nama'     => 'required|max_length[100]',
            'username' => "required|alpha_numeric|min_length[4]|max_length[50]|is_unique[users.username,id_user,{$id}]",
            'role'     => 'required|in_list[admin,laboran]',
        ];

        if ($this->request->getPost('password') !== '') {
            $rules['password'] = 'min_length[6]';
        }

        $pesan = ['username' => ['is_unique' => 'Username sudah digunakan.']];

        if (! $this->validate($rules, $pesan)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama'     => trim($this->request->getPost('nama')),
            'username' => $this->request->getPost('username'),
            'role'     => $this->request->getPost('role'),
        ];

        if ($this->request->getPost('password') !== '') {
            $data['password'] = password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $userModel->update($id, $data);

        return redirect()->to('/users')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        if ($id === (int) session()->get('id_user')) {
            return redirect()->to('/users')->with('error', 'Anda tidak dapat menghapus akun yang sedang dipakai.');
        }
        if ((new PeminjamanModel())->where('id_user', $id)->countAllResults() > 0) {
            return redirect()->to('/users')->with('error', 'Pengguna sudah memiliki riwayat transaksi sehingga tidak dapat dihapus.');
        }

        (new UserModel())->delete($id);

        return redirect()->to('/users')->with('success', 'Pengguna berhasil dihapus.');
    }
}
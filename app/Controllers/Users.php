<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Users extends BaseController
{
    protected $users;

    public function __construct()
    {
        $this->users = new UsersModel();
    }

    // ================= REGISTER (PUBLIK) =================
    public function create()
    {
        return view('users/create');
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        // ❌ HAPUS role dari validasi
        $validation->setRules([
            'nama'     => 'required',
            'email'    => 'required|valid_email',
            'username' => 'required|is_unique[users.username]',
            'password' => 'required|min_length[4]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('error', implode('<br>', $validation->getErrors()));
        }

        // ================= FOTO =================
        $foto = $this->request->getFile('foto');
        $namaFoto = null;

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/users', $namaFoto);
        }

        // ================= SIMPAN USERS =================
        $this->users->insert([
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'anggota', // ✅ AUTO ROLE
            'foto'     => $namaFoto
        ]);

        $userId = $this->users->insertID();

        // ================= AUTO MASUK KE TABEL ANGGOTA =================
        $anggotaModel = new \App\Models\AnggotaModel();
        $anggotaModel->insert([
            'user_id' => $userId,
            'alamat'  => $this->request->getPost('alamat'),
            'no_hp'   => $this->request->getPost('no_hp'),
            'tanggal_daftar' => date('Y-m-d')
        ]);

        return redirect()->to('/login')->with('success', 'User berhasil daftar!');
    }

    // ================= PROFILE =================
    public function profile()
    {
        $id = session()->get('id');
        $user = $this->users->find($id);

        return view('users/edit', ['user' => $user]);
    }

    public function updateProfile()
    {
        $id = session()->get('id');
        $user = $this->users->find($id);

        // ================= FOTO =================
        $fotoBaru = $this->request->getFile('foto');
        $namaFoto = $user['foto'];

        if ($fotoBaru && $fotoBaru->isValid() && $fotoBaru->getName() != '') {

            if (!empty($user['foto']) && file_exists(FCPATH . 'uploads/users/' . $user['foto'])) {
                unlink(FCPATH . 'uploads/users/' . $user['foto']);
            }

            $namaFoto = $fotoBaru->getRandomName();
            $fotoBaru->move(FCPATH . 'uploads/users', $namaFoto);
        }

        $data = [
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'foto'     => $namaFoto
        ];

        // password opsional
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->users->update($id, $data);

        return redirect()->to('/profile')->with('success', 'Profil berhasil diupdate');
    }

    // ================= ADMIN AREA =================
    public function index()
    {
        $data['users'] = $this->users->paginate(10);
        $data['pager'] = $this->users->pager;

        return view('users/index', $data);
    }

    public function edit($id)
    {
        $data['user'] = $this->users->find($id);
        return view('users/edit', $data);
    }

    public function update($id)
    {
        $data = [
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->users->update($id, $data);

        return redirect()->to('/users')->with('success', 'Data berhasil diupdate');
    }

    public function delete($id)
    {
        $this->users->delete($id);
        return redirect()->to('/users')->with('success', 'User dihapus');
    }
}
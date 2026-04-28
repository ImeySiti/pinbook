<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\AnggotaModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Users extends BaseController
{
    protected $users;

    public function __construct()
    {
        $this->users = new UsersModel();
    }

    // ================= REGISTER =================
    public function create()
    {
        return view('users/create');
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama'     => 'required',
            'email'    => 'required|valid_email',
            'username' => 'required|is_unique[users.username]',
            'password' => 'required|min_length[4]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->with('error', implode('<br>', $validation->getErrors()));
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
            'role'     => 'anggota',
            'foto'     => $namaFoto
        ]);

        $userId = $this->users->insertID();

        // ================= ANGGOTA =================
        $anggotaModel = new AnggotaModel();

        $anggotaModel->insert([
            'user_id' => $userId,
            'alamat'  => $this->request->getPost('alamat'),
            'no_hp'   => $this->request->getPost('no_hp'),
            'tanggal_daftar' => date('Y-m-d')
        ]);

        return redirect()->to('/login')
            ->with('success', 'User berhasil daftar!');
    }

    // ================= PROFILE (SESSION BASED) =================
    public function profile()
    {
        $id = session()->get('id');

        if (!$id) {
            return redirect()->to('/login');
        }

        $user = $this->users->find($id);

        if (!$user) {
            throw PageNotFoundException::forPageNotFound('User tidak ditemukan');
        }

        return view('users/edit', ['user' => $user]);
    }

    public function updateProfile()
    {
        $id = session()->get('id');

        if (!$id) {
            return redirect()->to('/login');
        }

        $user = $this->users->find($id);

        if (!$user) {
            throw PageNotFoundException::forPageNotFound('User tidak ditemukan');
        }

        // ================= FOTO =================
        $fotoBaru = $this->request->getFile('foto');
        $namaFoto = $user['foto'];

        if ($fotoBaru && $fotoBaru->isValid() && !$fotoBaru->hasMoved()) {

            if (!empty($user['foto']) && file_exists(FCPATH . 'uploads/users/' . $user['foto'])) {
                unlink(FCPATH . 'uploads/users/' . $user['foto']);
            }

            $namaFoto = $fotoBaru->getRandomName();
            $fotoBaru->move(FCPATH . 'uploads/users', $namaFoto);
        }

        // ================= UPDATE DATA =================
        $data = [
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'foto'     => $namaFoto
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            );
        }

        $this->users->update($id, $data);

        return redirect()->to('/profile')
            ->with('success', 'Profil berhasil diupdate');
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

    public function detail($id)
    {
        $user = $this->users->find($id);

        if (!$user) {
            throw PageNotFoundException::forPageNotFound('User tidak ditemukan');
        }

        return view('users/detail', ['user' => $user]);
    }

    public function update($id)
    {
        $data = [
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            );
        }

        $this->users->update($id, $data);

        return redirect()->to('/users')
            ->with('success', 'Data berhasil diupdate');
    }

    public function delete($id)
    {
        $this->db = \Config\Database::connect();

        $this->db->table('users')
            ->where('id', $id)
            ->delete();

        return redirect()->to(base_url('users'))
            ->with('success', 'User berhasil dihapus');
    }
}
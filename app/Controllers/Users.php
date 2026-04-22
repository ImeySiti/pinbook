<?php

// Namespace controller (menentukan lokasi file dalam struktur CI4)
namespace App\Controllers;

// Menggunakan model UsersModel untuk interaksi database
use App\Models\UsersModel;

// Class Users mewarisi BaseController (class utama di CI4)
class Users extends BaseController
{
    // Properti untuk menampung instance model
    protected $users;

    // Constructor: dijalankan saat controller dipanggil
    public function __construct()
    {
        // Inisialisasi model UsersModel
        $this->users = new UsersModel();
    }

    // Menampilkan halaman form tambah user
    public function create()
    {
        // Memanggil view users/create.php
        return view('users/create');
    }

    // Menyimpan data user baru
    public function store()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama'     => 'required',
            'email'    => 'required|valid_email',
            'username' => 'required|is_unique[users.username]',
            'password' => 'required|min_length[4]',
            'role'     => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('error', implode('<br>', $validation->getErrors()));
        }

        // ================= UPLOAD FOTO =================
        $foto = $this->request->getFile('foto');
        $namaFoto = null;

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/users', $namaFoto);
        }

        // ================= TRANSACTION =================
        $db = \Config\Database::connect();
        $db->transStart();

        // ================= SIMPAN USERS =================
        $this->users->insert([
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
            'foto'     => $namaFoto
        ]);

        // Ambil ID user yang baru dibuat
        $userId = $this->users->insertID();

        // ================= JIKA ROLE ANGGOTA =================
        if ($this->request->getPost('role') == 'anggota') {

            $anggotaModel = new \App\Models\AnggotaModel();

            $anggotaModel->insert([
                'user_id' => $userId,
                'nis' => $this->request->getPost('nis'), // opsional
                'alamat' => $this->request->getPost('alamat'),
                'no_hp' => $this->request->getPost('no_hp'),
                'tanggal_daftar' => date('Y-m-d')
            ]);
        } elseif ($this->request->getPost('role') == 'petugas') {

            $petugasModel = new \App\Models\PetugasModel();

            $petugasModel->insert([
                'user_id' => $userId,
                'jabatan' => $this->request->getPost('jabatan'),
                'tanggal_mulai' => date('Y-m-d')
            ]);
        }


        // ================= SELESAI TRANSACTION =================
        $db->transComplete();

        // Jika gagal
        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan data!');
        }

        return redirect()->to('/login')->with('success', 'User berhasil ditambahkan!');
    }
    // Menampilkan daftar user (dengan filter & pagination)
    public function index()
    {
        // Ambil parameter GET (search & filter)
        $keyword = $this->request->getGet('keyword');
        $role = $this->request->getGet('role');

        // Builder awal dari model
        $builder = $this->users;

        // Jika ada keyword → filter berdasarkan nama
        if ($keyword) {
            $builder = $builder->like('nama', $keyword);
        }

        // Jika ada filter role
        if ($role) {
            $builder = $builder->where('role', $role);
        }

        // Ambil data dengan pagination (10 data per halaman)
        $data['users'] = $builder->paginate(10);

        // Pager untuk navigasi halaman
        $data['pager'] = $this->users->pager;

        // Kirim data ke view
        return view('users/index', $data);
    }

    // Menampilkan form edit user
    public function edit($id)
    {
        // Ambil data user berdasarkan id
        $data['user'] = $this->users->find($id);

        // Tampilkan view edit
        return view('users/edit', $data);
    }

    // Update data user
    public function update($id)
    {
        // Ambil data user lama
        $user = $this->users->find($id);

        // Ambil file foto baru
        $fotoBaru = $this->request->getFile('foto');

        // Default pakai foto lama
        $namaFoto = $user['foto'];

        // Jika user upload foto baru
        if ($fotoBaru && $fotoBaru->isValid() && $fotoBaru->getName() != '') {

            // Hapus foto lama jika ada di folder
            if (!empty($user['foto']) && file_exists(FCPATH . 'uploads/users/' . $user['foto'])) {
                unlink(FCPATH . 'uploads/users/' . $user['foto']);
            }

            // Generate nama baru
            $namaFoto = $fotoBaru->getRandomName();

            // Simpan file baru
            $fotoBaru->move(FCPATH . 'uploads/users', $namaFoto);
        }

        // Data yang akan diupdate
        $data = [
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'role'     => $this->request->getPost('role'),
            'foto'     => $namaFoto
        ];

        // Jika password diisi → update password
        if ($this->request->getPost('password') != "") {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        // Jalankan update ke database
        $this->users->update($id, $data);

        // Redirect dengan pesan sukses
        return redirect()->to('/users')->with('success', 'Data user berhasil diupdate!');
    }

    // Menghapus user
    public function delete($id)
    {
        // Ambil data user
        $user = $this->users->find($id);

        // Hapus foto jika ada
        if ($user['foto'] && file_exists(FCPATH . 'uploads/users/' . $user['foto'])) {
            unlink(FCPATH . 'uploads/users/' . $user['foto']);
        }

        // Hapus data user di database
        $this->users->delete($id);

        // Redirect dengan pesan sukses
        return redirect()->to('/users')->with('success', 'User berhasil dihapus!');
    }

    // ================= DETAIL USER =================
    public function detail($id)
    {
        // Ambil data user
        $user = $this->users->find($id);

        // Jika tidak ditemukan
        if (!$user) {
            return redirect()->to('/users')->with('error', 'Data tidak ditemukan');
        }

        // Tampilkan detail
        return view('users/detail', ['user' => $user]);
    }

    // ================= PRINT DATA =================
    public function print()
    {
        // Ambil filter
        $keyword = $this->request->getGet('keyword');
        $role = $this->request->getGet('role');

        // Builder query
        $builder = $this->users;

        // Filter keyword
        if ($keyword) {
            $builder = $builder->like('nama', $keyword);
        }

        // Filter role
        if ($role) {
            $builder = $builder->where('role', $role);
        }

        // Ambil semua data (tanpa pagination)
        $data['users'] = $builder->findAll();

        // Tampilkan view print
        return view('users/print', $data);
    }

    // ================= KIRIM WHATSAPP =================
    public function wa($id)
    {
        // Ambil data user
        $user = $this->users->find($id);

        // Jika tidak ada
        if (!$user) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // ================= FORMAT PESAN =================
        $pesan = "DATA USER\n\n";
        $pesan .= "ID: " . $user['id'] . "\n";
        $pesan .= "Nama: " . $user['nama'] . "\n";
        $pesan .= "Email: " . $user['email'] . "\n";
        $pesan .= "Username: " . $user['username'] . "\n";
        $pesan .= "Role: " . ucfirst($user['role']) . "\n";

        // Encode agar aman di URL
        $url = "https://wa.me/6285175017991?text=" . urlencode($pesan);

        // Redirect ke WhatsApp
        return redirect()->to($url);
    }
}

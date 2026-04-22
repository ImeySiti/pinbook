<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\AnggotaModel;
use App\Models\PetugasModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    protected $usersModel;
    protected $anggotaModel;
    protected $petugasModel;
    protected $db;

    public function __construct()
    {
        $this->usersModel = new UsersModel();
        $this->anggotaModel = new AnggotaModel();
        $this->petugasModel = new PetugasModel();
        $this->db = \Config\Database::connect();
    }

    // ================= LOGIN =================
    public function login()
    {
        return view('auth/login');
    }

    // ================= PROSES LOGIN =================
    public function prosesLogin()
    {
        $session = session();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $users = $this->usersModel->getUsersByUsername($username);

        if ($users) {
            if (password_verify($password, $users['password'])) {

                $idAnggota = null;
                $idPetugas = null;

                if ($users['role'] == 'anggota') {
                    $anggota = $this->anggotaModel->where('user_id', $users['id'])->first();
                    if ($anggota) $idAnggota = $anggota['id_anggota'];
                } else if ($users['role'] == 'petugas') {
                    $petugas = $this->petugasModel->where('user_id', $users['id'])->first();
                    if ($petugas) $idPetugas = $petugas['id_petugas'];
                }

                $session->set([
                    'id' => $users['id'],
                    'id_anggota' => $idAnggota,
                    'id_petugas' => $idPetugas,
                    'nama' => $users['nama'],
                    'username' => $users['username'],
                    'role' => $users['role'],
                    'logged_in' => true
                ]);

                return redirect()->to('/dashboard');

            } else {
                return redirect()->to('/login')->with('error', 'Password salah');
            }
        }

        return redirect()->to('/login')->with('error', 'Username tidak ditemukan');
    }

    // ================= REGISTER =================
    public function prosesRegister()
    {
        $nama = $this->request->getPost('nama');
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $cek = $this->usersModel->where('username', $username)->first();
        if ($cek) {
            return redirect()->back()->with('error', 'Username sudah digunakan');
        }

        $this->db->table('users')->insert([
            'nama' => $nama,
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'anggota',
            'foto' => 'default.png'
        ]);

        $id_user = $this->db->insertID();

        $this->db->table('anggota')->insert([
            'user_id' => $id_user,
            'nis' => null,
            'alamat' => null,
            'no_hp' => null,
            'tanggal_daftar' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/login')->with('success', 'Berhasil daftar');
    }

    // ================= LOGOUT (INI YANG BENAR) =================
    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login')->with('success', 'Berhasil logout');
    }
}
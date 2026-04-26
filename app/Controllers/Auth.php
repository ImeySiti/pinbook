<?php

namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    // Menampilkan halaman view/auth/login
    public function login()
    {
        return view('auth/login');
    }

    // Memproses data login yang diinput pada halaman login
    public function prosesLogin()
    {
        $session = session();
        $usersModel = new UsersModel();
        $anggotaModel = new \App\Models\AnggotaModel();
        $petugasModel = new \App\Models\PetugasModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $users = $usersModel->getUsersByUsername($username);

        if ($users) {
            if (password_verify($password, $users['password'])) {

                // ================= CEK ANGGOTA =================
                $idAnggota = null;
                $idPetugas = null;

                if ($users['role'] == 'anggota') {
                    $anggota = $anggotaModel
                        ->where('user_id', $users['id'])
                        ->first();

                    if ($anggota) {
                        $idAnggota = $anggota['id_anggota'];
                    }
                } else if ($users['role'] == 'petugas') {
                    $petugas = $petugasModel
                        ->where('user_id', $users['id'])
                        ->first();

                    if ($petugas) {
                        $idPetugas = $petugas['id_petugas'];
                    }
                }

                // ================= SET SESSION =================
                $session->set([
                    'id' => $users['id'],
                    'id_anggota' => $idAnggota, // <-- TAMBAHAN
                    'id_petugas' => $idPetugas, // <-- TAMBAHAN
                    'nama' => $users['nama'],
                    'email' => $users['email'],
                    'username' => $users['username'],
                    'foto' => $users['foto'],
                    'logged_in' => true
                ]);

                return redirect()->to('/dashboard');
            } else {
                $session->setFlashdata('salahpw', 'Password salah');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('error', 'Nama tidak ditemukan');
            return redirect()->to('/login');
        }
    }

    // Logout (keluar dari aplikasi)
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}

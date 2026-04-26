<?php

namespace App\Controllers;

class Anggota extends BaseController
{
    // ================= HALAMAN PROFIL =================
    public function profil()
    {
        $id_anggota = session()->get('id_anggota');

        $db = \Config\Database::connect();

        $data['anggota'] = $db->table('anggota')
            ->where('id_anggota', $id_anggota)
            ->get()
            ->getRowArray();

        return view('anggota/profil', $data);
    }

    // ================= SIMPAN PROFIL =================
    public function store()
    {
        $id_anggota = session()->get('id_anggota');

        $db = \Config\Database::connect();

        $db->table('anggota')
            ->where('id_anggota', $id_anggota)
            ->update([
                'nisn'   => $this->request->getPost('nisn'),
                'alamat' => $this->request->getPost('alamat'),
                'no_hp'  => $this->request->getPost('no_hp')
            ]);

        return redirect()->to('/peminjaman/create')
            ->with('success', 'Profil berhasil dilengkapi');
    }
}
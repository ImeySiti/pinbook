<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\UsersModel;

class Anggota extends BaseController
{
    protected $anggotaModel;
    protected $usersModel;
    protected $db;

    public function __construct()
    {
        $this->anggotaModel = new AnggotaModel();
        $this->usersModel = new UsersModel();

        // 🔥 FIX PENTING
        $this->db = \Config\Database::connect();
    }

    // ================= LIST =================
    public function index()
    {
        $data['anggota'] = $this->db->table('anggota a')
            ->select('a.*, u.nama')
            ->join('users u', 'u.id = a.user_id', 'left')
            ->get()->getResultArray();

        return view('anggota/index', $data);
    }

    public function print()
{
    $data['anggota'] = $this->db->table('anggota a')
        ->select('a.*, u.nama')
        ->join('users u', 'u.id = a.user_id', 'left')
        ->get()->getResultArray();

    return view('anggota/print', $data);
}
    // ================= WA =================
    public function wa($id)
    {
        $a = $this->db->table('anggota a')
            ->select('a.*, u.nama')
            ->join('users u', 'u.id = a.user_id', 'left')
            ->where('a.id_anggota', $id)
            ->get()->getRowArray();

        if (!$a) {
            return redirect()->to('/anggota');
        }

        // 🔥 FIX AMAN NO HP
        $no = preg_replace('/[^0-9]/', '', $a['no_hp']);
        if (substr($no, 0, 1) == '0') {
            $no = '62' . substr($no, 1);
        }

        $pesan = "DATA ANGGOTA\n\n";
        $pesan .= "Nama: " . $a['nama'] . "\n";
        $pesan .= "NIS: " . $a['nis'] . "\n";
        $pesan .= "Alamat: " . $a['alamat'] . "\n";
        $pesan .= "No HP: " . $a['no_hp'] . "\n";

        return redirect()->to("https://wa.me/".$no."?text=".urlencode($pesan));
    }

    // ================= STORE =================
    public function store()
    {
        $this->anggotaModel->insert([
            'user_id' => $this->request->getPost('user_id'),
            'nis'     => $this->request->getPost('nis'),
            'alamat'  => $this->request->getPost('alamat'),
            'no_hp'   => $this->request->getPost('no_hp')
        ]);

        return redirect()->to('/anggota')->with('success', 'Berhasil tambah');
    }

    // ================= DELETE =================
    public function delete($id)
    {
        $this->anggotaModel->delete($id);
        return redirect()->to('/anggota');
    }
}
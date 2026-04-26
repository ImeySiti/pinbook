<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\PengembalianModel;
use App\Models\DendaModel;
use CodeIgniter\Controller;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class Pengembalian extends Controller
{
    protected $db;
    protected $peminjamanModel;
    protected $pengembalianModel;
    protected $dendaModel;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->peminjamanModel = new PeminjamanModel();
        $this->pengembalianModel = new PengembalianModel();
        $this->dendaModel = new DendaModel();
    }

    // ================= INDEX =================
    public function index()
{
    $data['pengembalian'] = $this->db->table('pengembalian')
        ->select('
            pengembalian.*,
            peminjaman.id_anggota,
            users.nama as nama_anggota
        ')
        ->join('peminjaman', 'peminjaman.id_peminjaman = pengembalian.id_peminjaman')
        ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
        ->join('users', 'users.id = anggota.user_id', 'left')
        ->get()
        ->getResultArray();

    return view('pengembalian/index', $data);
}

    // ================= SIMPAN PENGEMBALIAN =================
    public function simpan()
    {
        $id_peminjaman = $this->request->getPost('id_peminjaman');
        $denda_input   = $this->request->getPost('denda');

        if (!$id_peminjaman) {
            return redirect()->back()->with('error', 'ID peminjaman tidak valid');
        }

        $this->db->transStart();

        // insert pengembalian
        $this->pengembalianModel->insert([
            'id_peminjaman' => $id_peminjaman,
            'tanggal_dikembalikan' => date('Y-m-d'),
            'denda' => $denda_input
        ]);

        $id_pengembalian = $this->pengembalianModel->insertID();

        // insert denda
        $this->dendaModel->insert([
            'id_pengembalian' => $id_pengembalian,
            'jumlah_denda' => $denda_input,
            'status' => ($denda_input > 0) ? 'belum' : 'lunas'
        ]);

        // update status peminjaman
        $this->peminjamanModel->update($id_peminjaman, [
            'status' => 'dikembalikan'
        ]);

        $this->db->transComplete();

        return redirect()->to('/pengembalian')
            ->with('success', 'Pengembalian berhasil disimpan');
    }

  // ================= BAYAR DENDA =================
public function bayar($id)
{
    $p = $this->db->table('pengembalian')
        ->select('pengembalian.*, denda.id_denda, denda.jumlah_denda')
        ->join('denda', 'denda.id_pengembalian = pengembalian.id_pengembalian', 'left')
        ->where('pengembalian.id_pengembalian', $id)
        ->get()
        ->getRowArray();

    if (!$p) {
        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }

    return view('pengembalian/bayar', [
        'p' => $p
    ]);
}
}
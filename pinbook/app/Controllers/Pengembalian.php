<?php

namespace App\Controllers;

use App\Models\PengembalianModel;
use App\Models\DendaModel;
use App\Models\PeminjamanModel;

class Pengembalian extends BaseController
{
    protected $db;
    protected $pengembalianModel;
    protected $dendaModel;
    protected $peminjamanModel;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->pengembalianModel = new PengembalianModel();
        $this->dendaModel = new DendaModel();
        $this->peminjamanModel = new PeminjamanModel();
    }

    // ==========================
    // LIST PENGEMBALIAN (USER_ID FIX)
    // ==========================
  public function index()
{
    $builder = $this->db->table('pengembalian p');

    $builder->select('
        p.*,
        users.nama as nama_anggota,
        GROUP_CONCAT(b.judul SEPARATOR ", ") as daftar_buku,
        d.id_denda,
        d.jumlah_denda,
        d.status as status_bayar
    ')
    ->join('peminjaman pm', 'pm.id_peminjaman = p.id_peminjaman', 'left')

    // 🔥 SAMA PERSIS DENGAN PEMINJAMAN KAMU
    ->join('anggota', 'anggota.id_anggota = pm.id_anggota', 'left')
    ->join('users', 'users.id = anggota.user_id', 'left')

    ->join('detail_peminjaman dp', 'dp.id_peminjaman = pm.id_peminjaman', 'left')
    ->join('buku b', 'b.id_buku = dp.id_buku', 'left')
    ->join('denda d', 'd.id_pengembalian = p.id_pengembalian', 'left')

    ->groupBy('p.id_pengembalian');

    // kalau nanti mau filter anggota login
    if (session()->get('role') == 'anggota') {
        $builder->where('pm.id_anggota', session()->get('id_anggota'));
    }

    $data['pengembalian'] = $builder->get()->getResultArray();

    return view('pengembalian/index', $data);
}
    // ==========================
    // SIMPAN PENGEMBALIAN + DENDA
    // ==========================
    public function simpan()
    {
        $id_peminjaman = $this->request->getPost('id_peminjaman');
        $denda_input   = $this->request->getPost('denda');

        if (!$id_peminjaman) {
            return redirect()->back()->with('error', 'ID peminjaman tidak valid');
        }

        $this->db->transStart();

        // 1. INSERT PENGEMBALIAN
        $this->pengembalianModel->insert([
            'id_peminjaman' => $id_peminjaman,
            'tanggal_dikembalikan' => date('Y-m-d'),
            'denda' => $denda_input
        ]);

        $id_pengembalian = $this->pengembalianModel->getInsertID();

        // 2. INSERT DENDA
        $this->dendaModel->insert([
            'id_pengembalian' => $id_pengembalian,
            'jumlah_denda' => $denda_input,
            'status' => ($denda_input > 0) ? 'belum' : 'lunas'
        ]);

        // 3. UPDATE PEMINJAMAN
        $this->peminjamanModel->update($id_peminjaman, [
            'status' => 'dikembalikan'
        ]);

        $this->db->transComplete();

        return redirect()->to('/pengembalian')
            ->with('success', 'Pengembalian berhasil disimpan');
    }

    // ==========================
    // HALAMAN BAYAR DENDA
    // ==========================
    public function bayar($id_pengembalian)
    {
        $data = $this->db->table('pengembalian p')
            ->select('
                p.id_pengembalian,
                p.id_peminjaman,
                p.denda,

                d.id_denda,
                d.jumlah_denda,
                d.status as status_bayar
            ')
            ->join('denda d', 'd.id_pengembalian = p.id_pengembalian', 'left')
            ->where('p.id_pengembalian', $id_pengembalian)
            ->get()
            ->getRowArray();

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        return view('pengembalian/bayar', [
            'p' => $data
        ]);
    }
}
<?php

namespace App\Controllers;

use App\Models\PengembalianModel;
use App\Models\PeminjamanModel;

class Pengembalian extends BaseController
{
    protected $pengembalian;
    protected $peminjaman;

    public function __construct()
    {
        $this->pengembalian = new PengembalianModel();
        $this->peminjaman   = new PeminjamanModel();
    }

    // =========================
    // LIST
    // =========================
    public function index()
    {
        $db = \Config\Database::connect();

        $data['pengembalian'] = $db->table('pengembalian')
            ->select('
                pengembalian.id_pengembalian,
                pengembalian.tanggal_dikembalikan,
                pengembalian.denda,

                peminjaman.id_peminjaman,
                peminjaman.tanggal_pinjam,
                peminjaman.tanggal_kembali as batas_kembali,

                u_anggota.nama as nama_anggota,
                GROUP_CONCAT(buku.judul SEPARATOR ", ") as daftar_buku
            ')
            ->join('peminjaman', 'peminjaman.id_peminjaman = pengembalian.id_peminjaman', 'left')
            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
            ->join('users u_anggota', 'u_anggota.id = anggota.user_id', 'left')
            ->join('detail_peminjaman', 'detail_peminjaman.id_peminjaman = peminjaman.id_peminjaman', 'left')
            ->join('buku', 'buku.id_buku = detail_peminjaman.id_buku', 'left')
            ->groupBy('pengembalian.id_pengembalian')
            ->get()
            ->getResultArray();

        // =========================
        // HITUNG DENDA (VIEW ONLY)
        // =========================
        foreach ($data['pengembalian'] as &$p) {

            $denda = 0;

            if (!empty($p['batas_kembali']) && !empty($p['tanggal_dikembalikan'])) {

                $batas   = strtotime($p['batas_kembali']);
                $kembali = strtotime($p['tanggal_dikembalikan']);

                $telat = ($kembali - $batas) / 86400;

                if ($telat > 0) {
                    $denda = $telat * 15000;
                }
            }

            $p['denda_otomatis'] = $denda;
        }

        return view('pengembalian/index', $data);
    }

    // =========================
    // CREATE FORM
    // =========================
    public function create()
    {
        return view('pengembalian/create', [
            'peminjaman' => $this->peminjaman->findAll()
        ]);
    }

    // =========================
    // STORE (DENDA AUTO)
    // =========================
    public function store()
    {
        $id_peminjaman = $this->request->getPost('id_peminjaman');
        $tanggal_kembali = $this->request->getPost('tanggal_dikembalikan');

        // ambil data peminjaman
        $pinjam = $this->peminjaman->find($id_peminjaman);

        $denda = 0;

        if (!empty($pinjam['tanggal_kembali'])) {

            $batas   = strtotime($pinjam['tanggal_kembali']);
            $kembali = strtotime($tanggal_kembali);

            $telat = ($kembali - $batas) / 86400;

            if ($telat > 0) {
                $denda = $telat * 15000;
            }
        }

        $this->pengembalian->save([
            'id_peminjaman'        => $id_peminjaman,
            'tanggal_dikembalikan' => $tanggal_kembali,
            'denda'                => $denda
        ]);

        return redirect()->to('/pengembalian');
    }

    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {
        return view('pengembalian/edit', [
            'pengembalian' => $this->pengembalian->find($id),
            'peminjaman'   => $this->peminjaman->findAll()
        ]);
    }

    // =========================
    // UPDATE
    // =========================
    public function update($id)
    {
        $id_peminjaman = $this->request->getPost('id_peminjaman');
        $tanggal_kembali = $this->request->getPost('tanggal_dikembalikan');

        $pinjam = $this->peminjaman->find($id_peminjaman);

        $denda = 0;

        if (!empty($pinjam['tanggal_kembali'])) {

            $batas   = strtotime($pinjam['tanggal_kembali']);
            $kembali = strtotime($tanggal_kembali);

            $telat = ($kembali - $batas) / 86400;

            if ($telat > 0) {
                $denda = $telat * 15000;
            }
        }

        $this->pengembalian->update($id, [
            'id_peminjaman'        => $id_peminjaman,
            'tanggal_dikembalikan' => $tanggal_kembali,
            'denda'                => $denda
        ]);

        return redirect()->to('/pengembalian');
    }

    // =========================
    // DELETE
    // =========================
    public function delete($id)
    {
        $this->pengembalian->delete($id);
        return redirect()->to('/pengembalian');
    }
}
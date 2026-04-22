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
    $session = session();
    $role = $session->get('role');
    $id_anggota = $session->get('id_anggota');

    $db = \Config\Database::connect();

    $builder = $db->table('pengembalian')
        ->select('
            pengembalian.id_pengembalian,
            pengembalian.tanggal_dikembalikan,
            pengembalian.denda,

            peminjaman.id_peminjaman,
            peminjaman.tanggal_pinjam,
            peminjaman.tanggal_kembali as batas_kembali,

            u.nama as nama_anggota,
            GROUP_CONCAT(buku.judul SEPARATOR ", ") as daftar_buku
        ')
        ->join('peminjaman', 'peminjaman.id_peminjaman = pengembalian.id_peminjaman', 'left')
        ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
        ->join('users u', 'u.id = anggota.user_id', 'left')
        ->join('detail_peminjaman', 'detail_peminjaman.id_peminjaman = peminjaman.id_peminjaman', 'left')
        ->join('buku', 'buku.id_buku = detail_peminjaman.id_buku', 'left')
        ->groupBy('pengembalian.id_pengembalian');

    // 🔥 INI YANG KAMU LUPA
    if ($role != 'admin') {
        $builder->where('peminjaman.id_anggota', $id_anggota);
    }

    $data['pengembalian'] = $builder->get()->getResultArray();

    // hitung denda otomatis
    foreach ($data['pengembalian'] as &$p) {
        $p['denda_otomatis'] = 0;

        if (!empty($p['batas_kembali']) && !empty($p['tanggal_dikembalikan'])) {

            $batas = strtotime($p['batas_kembali']);
            $kembali = strtotime($p['tanggal_dikembalikan']);

            if ($kembali > $batas) {
                $telat = ($kembali - $batas) / 86400;
                $p['denda_otomatis'] = $telat * 15000;
            }
        }
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
    // STORE
    // =========================
    public function store()
    {
        $id_peminjaman = $this->request->getPost('id_peminjaman');
        $tanggal_kembali = $this->request->getPost('tanggal_dikembalikan');

        $pinjam = $this->peminjaman->find($id_peminjaman);

        $denda = $this->hitungDenda($pinjam['tanggal_kembali'], $tanggal_kembali);

        $this->pengembalian->save([
            'id_peminjaman'        => $id_peminjaman,
            'tanggal_dikembalikan' => $tanggal_kembali,
            'denda'                => $denda
        ]);

        return redirect()->to('/pengembalian');
    }

    // =========================
    // UPDATE
    // =========================
    public function update($id)
    {
        $id_peminjaman = $this->request->getPost('id_peminjaman');
        $tanggal_kembali = $this->request->getPost('tanggal_dikembalikan');

        $pinjam = $this->peminjaman->find($id_peminjaman);

        $denda = $this->hitungDenda($pinjam['tanggal_kembali'], $tanggal_kembali);

        $this->pengembalian->update($id, [
            'id_peminjaman'        => $id_peminjaman,
            'tanggal_dikembalikan' => $tanggal_kembali,
            'denda'                => $denda
        ]);

        return redirect()->to('/pengembalian');
    }

    // =========================
    // FUNCTION DENDA
    // =========================
    private function hitungDenda($batas, $kembali)
    {
        if (empty($batas) || empty($kembali)) return 0;

        $batas = strtotime($batas);
        $kembali = strtotime($kembali);

        if ($kembali <= $batas) return 0;

        $telat = ($kembali - $batas) / 86400;

        return $telat * 15000;
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
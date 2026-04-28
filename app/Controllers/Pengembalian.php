<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\PengembalianModel;
use CodeIgniter\Controller;

class Pengembalian extends Controller
{
    protected $db;
    protected $peminjamanModel;
    protected $pengembalianModel;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->peminjamanModel = new PeminjamanModel();
        $this->pengembalianModel = new PengembalianModel();
    }

    // ================= INDEX =================
 public function index()
{
    $builder = $this->db->table('pengembalian');

    $builder->select('
        pengembalian.id_pengembalian,
        pengembalian.id_peminjaman,
        pengembalian.tanggal_dikembalikan,
        pengembalian.denda,
        pengembalian.status_bayar,
        peminjaman.tanggal_pinjam,
        users.nama as nama_anggota
    ')
    ->join('peminjaman', 'peminjaman.id_peminjaman = pengembalian.id_peminjaman', 'left')
    ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
    ->join('users', 'users.id = anggota.user_id', 'left') // 🔥 FIX UTAMA
    ->orderBy('pengembalian.id_pengembalian', 'DESC');

    // filter anggota login
    if (session()->get('role') == 'anggota') {
        $builder->where('peminjaman.id_anggota', session()->get('id_anggota'));
    }

    return view('pengembalian/index', [
        'pengembalian' => $builder->get()->getResultArray()
    ]);
}
    // ================= SIMPAN =================
    public function simpan()
    {
        $id_peminjaman = $this->request->getPost('id_peminjaman');
        $denda = $this->request->getPost('denda') ?? 0;

        $pinjam = $this->peminjamanModel->find($id_peminjaman);

        if (!$pinjam) {
            return redirect()->back();
        }

        $this->db->transStart();

        $this->pengembalianModel->insert([
            'id_peminjaman' => $id_peminjaman,
            'tanggal_dikembalikan' => date('Y-m-d'),
            'denda' => $denda,
            'status_bayar' => ($denda > 0) ? 'belum' : 'lunas'
        ]);

        $this->peminjamanModel->update($id_peminjaman, [
            'status' => 'kembali',
            'status_pengantaran' => null
        ]);

        $detail = $this->db->table('detail_peminjaman')
            ->where('id_peminjaman', $id_peminjaman)
            ->get()->getResultArray();

        foreach ($detail as $d) {
            $this->db->table('buku')
                ->where('id_buku', $d['id_buku'])
                ->set('tersedia', 'tersedia + 1', false)
                ->update();
        }

        $this->db->transComplete();

        return redirect()->to('/pengembalian');
    }
public function kembalikan($id)
{
    $db = Database::connect();

    $pinjam = $this->peminjamanModel->find($id);

    if (!$pinjam) {
        return redirect()->to('/peminjaman')
            ->with('error', 'Data tidak ditemukan');
    }

    $db->transBegin();

    try {

        $detail = $db->table('detail_peminjaman')
            ->where('id_peminjaman', $id)
            ->get()->getResultArray();

        // update status
        $this->peminjamanModel->update($id, [
            'status' => 'kembali',
            'status_pengantaran' => 'selesai'
        ]);

        // insert pengembalian (INI KUNCI)
        $db->table('pengembalian')->insert([
            'id_peminjaman' => $id,
            'tanggal_dikembalikan' => date('Y-m-d H:i:s'),
            'denda' => 0,
            'status_bayar' => 'belum'
        ]);

        // update stok buku
        foreach ($detail as $d) {
            $db->table('buku')
                ->where('id_buku', $d['id_buku'])
                ->set('tersedia', 'tersedia + 1', false)
                ->update();
        }

        $db->transCommit();

    } catch (\Exception $e) {
        $db->transRollback();
        return redirect()->to('/peminjaman')
            ->with('error', 'Gagal mengembalikan buku: ' . $e->getMessage());
    }

    return redirect()->to('/peminjaman')
        ->with('success', 'Buku berhasil dikembalikan');
}
    // ================= BAYAR =================
    public function bayar($id)
    {
        $this->pengembalianModel->update($id, [
            'status_bayar' => 'lunas'
        ]);

        return redirect()->to('/pengembalian');
    }
}
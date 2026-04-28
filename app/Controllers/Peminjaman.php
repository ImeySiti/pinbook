<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\BukuModel;
use CodeIgniter\Controller;
use Config\Database;

class Peminjaman extends Controller
{
    protected $peminjamanModel;
    protected $bukuModel;

    public function __construct()
    {
        $this->peminjamanModel = new PeminjamanModel();
        $this->bukuModel = new BukuModel();
    }

    // =====================
    // INDEX
    // =====================
public function index()
{
    $db = \Config\Database::connect();

    $data['peminjaman'] = $db->table('peminjaman p')
        ->select('p.*, u.nama as nama_anggota')
        ->join('anggota a', 'a.id_anggota = p.id_anggota', 'left')
        ->join('users u', 'u.id = a.user_id', 'left') // 🔥 FIX UTAMA
        ->orderBy('p.id_peminjaman', 'DESC')
        ->get()
        ->getResultArray();

    return view('peminjaman/index', $data);
}
    // =====================
    // CREATE
    // =====================
    public function create()
    {
        $db = Database::connect();

        $kategori_list = $db->table('kategori')->get()->getResultArray();

        $q = $this->request->getGet('q');
        $kategori = $this->request->getGet('kategori');

        $builder = $db->table('buku');

        if (!empty($q)) {
            $builder->like('judul', $q);
        }

        if (!empty($kategori)) {
            $builder->where('id_kategori', $kategori);
        }

        $hasil_cari = $builder->get()->getResultArray();

        return view('peminjaman/create', [
            'rekomendasi' => $this->bukuModel->findAll(),
            'hasil_cari' => $hasil_cari,
            'kategori_list' => $kategori_list
        ]);
    }

    // =====================
    // PINJAM MULTI
    // =====================
 public function pinjamMulti()
{
    $db = Database::connect();

    $id_anggota = session()->get('id_anggota');
    $buku = $this->request->getPost('buku') ?? [];

    if (empty($buku)) {
        return redirect()->back()->with('error', 'Pilih minimal 1 buku');
    }

    $metode = $this->request->getPost('metode_pengambilan') ?? 'ambil';
    $alamat = $this->request->getPost('alamat');

    $db->table('peminjaman')->insert([
        'id_anggota' => $id_anggota,
        'tanggal_pinjam' => date('Y-m-d'),
        'tanggal_kembali' => date('Y-m-d', strtotime('+7 days')),

        // 🔥 FIX KONSISTEN
        'metode_pengambilan' => $metode,

        'alamat_pengantaran' => ($metode == 'antar') ? $alamat : null,

        // 🔥 GANTI SEMUA JADI INI
        'status_pengantaran' => ($metode == 'antar')
            ? 'menunggu_konfirmasi'
            : 'ambil',

        'status' => 'dipinjam'
    ]);

    $id = $db->insertID();

    foreach ($buku as $id_buku) {
        $db->table('detail_peminjaman')->insert([
            'id_peminjaman' => $id,
            'id_buku' => $id_buku
        ]);
    }

    return redirect()->to('/peminjaman');

}
    // =====================
    // STORE
    // =====================
    public function store()
{
    $db = Database::connect();

    $id_anggota = session()->get('id_anggota');
    $idBuku = $this->request->getPost('id_buku');
    $metode = $this->request->getPost('metode_pengambilan') ?? 'ambil';
    $alamat = $this->request->getPost('alamat');

    $db->table('peminjaman')->insert([
        'id_anggota' => $id_anggota,
        'tanggal_pinjam' => date('Y-m-d'),
        'tanggal_kembali' => date('Y-m-d', strtotime('+7 days')),

        'metode_pengambilan' => $metode,
        'alamat_pengantaran' => ($metode == 'antar') ? $alamat : null,

        'status_pengantaran' => ($metode == 'antar')
            ? 'menunggu_konfirmasi'
            : 'ambil',

        'status' => 'dipinjam'
    ]);

    $id = $db->insertID();

    if (!empty($idBuku)) {
        foreach ($idBuku as $b) {
            $db->table('detail_peminjaman')->insert([
                'id_peminjaman' => $id,
                'id_buku' => $b
            ]);
        }
    }

    return redirect()->to('/peminjaman');
}

    // =====================
    // KEMBALIKAN (FIX TRANSACTION ERROR)
    // =====================
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

public function kembali($id)
{
    // alias biar URL /kembali tidak error
    return $this->kembalikan($id);
}
public function bayarDenda($id)
{
    $db = \Config\Database::connect();

    $db->table('pengembalian')
        ->where('id_pengembalian', $id)
        ->update([
            'status_bayar' => 'lunas'
        ]);

    return redirect()->back()
        ->with('success', 'Denda berhasil dibayar');
}
    // =====================
    // DETAIL
    // =====================
    public function detail($id)
    {
        $db = Database::connect();

        $data['peminjaman'] = $db->table('peminjaman')
            ->where('id_peminjaman', $id)
            ->get()
            ->getRowArray();

        $data['buku'] = $db->table('detail_peminjaman dp')
            ->join('buku b', 'b.id_buku = dp.id_buku')
            ->where('dp.id_peminjaman', $id)
            ->get()
            ->getResultArray();

        return view('peminjaman/detail', $data);
    }

    // =====================
    // DELETE
    // =====================
    public function delete($id)
    {
        $db = Database::connect();

        $db->table('detail_peminjaman')->where('id_peminjaman', $id)->delete();
        $this->peminjamanModel->delete($id);

        return redirect()->to('/peminjaman');
    }
}
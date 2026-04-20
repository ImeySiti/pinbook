<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\DetailModel;
use App\Models\BukuModel;
use App\Models\PengembalianModel;

class Peminjaman extends BaseController
{
    protected $peminjamanModel;
    protected $detailModel;
    protected $bukuModel;
    protected $pengembalianModel;
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();

        $this->peminjamanModel = new PeminjamanModel();
        $this->detailModel = new DetailModel();
        $this->bukuModel = new BukuModel();
        $this->pengembalianModel = new PengembalianModel();
    }

    // ================= INDEX =================
    public function index()
{
    $builder = $this->db->table('peminjaman');

    $builder->select('
        peminjaman.*,
        u_anggota.nama as nama_anggota,
        u_petugas.nama as nama_petugas,
        GROUP_CONCAT(buku.judul SEPARATOR ", ") as daftar_buku
    ')
    ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
    ->join('users u_anggota', 'u_anggota.id = anggota.user_id', 'left')

    ->join('petugas', 'petugas.id_petugas = peminjaman.id_petugas', 'left')
    ->join('users u_petugas', 'u_petugas.id = petugas.user_id', 'left')

    ->join('detail_peminjaman', 'detail_peminjaman.id_peminjaman = peminjaman.id_peminjaman', 'left')
    ->join('buku', 'buku.id_buku = detail_peminjaman.id_buku', 'left')

    ->groupBy('peminjaman.id_peminjaman');

    // 🔥 FILTER ROLE
    if (session()->get('role') == 'anggota') {
        $builder->where('peminjaman.id_anggota', session()->get('id_anggota'));
    }

    $data['peminjaman'] = $builder->get()->getResultArray();

    return view('peminjaman/index', $data);
}

public function create()
{
    $keyword = $this->request->getGet('q');
    $kategori = $this->request->getGet('kategori');

    $query = $this->bukuModel;

    if ($keyword) {
        $query = $query->like('judul', $keyword);
    }

    if ($kategori) {
        $query = $query->where('id_kategori', $kategori);
    }

    $data['hasil_cari'] = $query->findAll();

    // rekomendasi buku
    $data['rekomendasi'] = $this->bukuModel
        ->orderBy('id_buku', 'RANDOM')
        ->limit(5)
        ->findAll();

    // anggota (pakai JOIN users biar nama tampil benar)
    $data['anggota'] = $this->db->table('anggota')
        ->select('anggota.*, users.nama as nama')
        ->join('users', 'users.id = anggota.user_id', 'left')
        ->get()
        ->getResultArray();
        

    return view('peminjaman/create', $data);
}

    // ================= DETAIL =================
   public function detail($id)
{
    // ambil data peminjaman + nama user dari tabel users
    $peminjaman = $this->peminjamanModel
        ->select('peminjaman.*, users.nama as nama_anggota, petugas.jabatan')
        ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
        ->join('users', 'users.id = anggota.user_id', 'left')
        ->join('petugas', 'petugas.id_petugas = peminjaman.id_petugas', 'left')
        ->where('peminjaman.id_peminjaman', $id)
        ->first();

    // kalau data tidak ditemukan
    if (!$peminjaman) {
        return redirect()->to('/peminjaman')->with('error', 'Data tidak ditemukan');
    }

    // ambil buku yang dipinjam
    $buku = $this->detailModel
        ->select('buku.judul')
        ->join('buku', 'buku.id_buku = detail_peminjaman.id_buku', 'left')
        ->where('detail_peminjaman.id_peminjaman', $id)
        ->findAll();

    return view('peminjaman/detail', [
        'peminjaman' => $peminjaman,
        'buku' => $buku
    ]);
}
   public function pinjam($id_buku)
{
    $buku = $this->bukuModel->find($id_buku);

    if ($buku['tersedia'] <= 0) {
        return redirect()->back()->with('error', 'Stok habis');
    }

    // 1. INSERT PEMINJAMAN
    $this->peminjamanModel->insert([
        'id_anggota' => session()->get('id_anggota'),
        'id_petugas' => session()->get('id_petugas'),
        'tanggal_pinjam' => date('Y-m-d'),
        'tanggal_kembali' => date('Y-m-d', strtotime('+7 days')),
        'status' => 'dipinjam'
    ]);

    // 🔥 AMBIL ID BARU
    $id_peminjaman = $this->peminjamanModel->insertID();

    // 2. INSERT DETAIL
    $this->detailModel->insert([
        'id_peminjaman' => $id_peminjaman,
        'id_buku' => $id_buku,
        'jumlah' => 1
    ]);

    // 3. UPDATE STOK
    $this->bukuModel->update($id_buku, [
        'tersedia' => $buku['tersedia'] - 1
    ]);

    return redirect()->to('/peminjaman');
}

    // ================= EDIT =================
    public function edit($id)
    {
        $data['peminjaman'] = $this->peminjamanModel->find($id);

        $data['detail'] = $this->detailModel
            ->select('detail_peminjaman.*, buku.judul')
            ->join('buku', 'buku.id_buku = detail_peminjaman.id_buku', 'left')
            ->where('id_peminjaman', $id)
            ->findAll();

        $data['rekomendasi'] = $this->bukuModel
            ->orderBy('id_buku', 'RANDOM')
            ->limit(5)
            ->findAll();

        $data['anggota'] = $this->db->table('anggota')->get()->getResultArray();

        return view('peminjaman/edit', $data);
    }

    // ================= UPDATE =================
    public function update($id)
    {
        $aksi = $this->request->getPost('aksi');

        if ($aksi == 'perpanjang') {
            $p = $this->peminjamanModel->find($id);

            $this->peminjamanModel->update($id, [
                'tanggal_kembali' => date('Y-m-d', strtotime($p['tanggal_kembali'].' +7 days')),
                'status' => 'diperpanjang'
            ]);
        }

        if ($aksi == 'tambah') {
            $id_buku = $this->request->getPost('id_buku');

            $buku = $this->bukuModel->find($id_buku);

            if ($buku && $buku['tersedia'] > 0) {
                $this->detailModel->insert([
                    'id_peminjaman' => $id,
                    'id_buku' => $id_buku,
                    'jumlah' => 1
                ]);

                $this->bukuModel->update($id_buku, [
                    'tersedia' => $buku['tersedia'] - 1
                ]);
            }
        }

        return redirect()->to('/peminjaman/edit/'.$id);
    }
// perpanjang
public function perpanjang($id)
{
    $peminjaman = $this->peminjamanModel->find($id);

    if (!$peminjaman) {
        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }

    // contoh: tambah 7 hari
    $tanggalBaru = date('Y-m-d', strtotime($peminjaman['tanggal_kembali'] . ' +7 days'));

    $this->peminjamanModel->update($id, [
        'tanggal_kembali' => $tanggalBaru
    ]);

    return redirect()->back()->with('success', 'Berhasil diperpanjang 7 hari');
}
    // ================= DELETE =================
   public function delete($id)
{
    // hapus pengembalian dulu
    $this->pengembalianModel
        ->where('id_peminjaman', $id)
        ->delete();

    // hapus detail peminjaman
    $this->detailModel
        ->where('id_peminjaman', $id)
        ->delete();

    // baru hapus peminjaman
    $this->peminjamanModel->delete($id);

    return redirect()->to('/peminjaman')
        ->with('success', 'Data berhasil dihapus');
}
    // ================= KEMBALI =================
public function kembali($id)
{
    $peminjaman = $this->peminjamanModel->find($id);

    if (!$peminjaman) {
        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }

    $bukuModel = new \App\Models\BukuModel();
    $detailModel = new \App\Models\DetailModel();
    $pengembalianModel = new \App\Models\PengembalianModel();

    // ambil semua buku dalam peminjaman
    $detail = $detailModel->where('id_peminjaman', $id)->findAll();

    foreach ($detail as $d) {
        $buku = $bukuModel->find($d['id_buku']);

        if ($buku) {
            // 1. tambah stok
            $bukuModel->update($d['id_buku'], [
                'tersedia' => $buku['tersedia'] + 1
            ]);

            // 2. simpan ke tabel pengembalian
            $pengembalianModel->insert([
                'id_peminjaman'   => $id,
                'id_buku'         => $d['id_buku'],
                'tanggal_kembali' => date('Y-m-d'),
                'denda'           => 0,
                'status'          => 'dikembalikan'
            ]);
        }
    }

    // 3. update status peminjaman
    $this->peminjamanModel->update($id, [
        'status' => 'kembali',
        'tanggal_kembali_real' => date('Y-m-d')
    ]);

    return redirect()->back()->with('success', 'Buku berhasil dikembalikan & masuk data pengembalian');
}
}
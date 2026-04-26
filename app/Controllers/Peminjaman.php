<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\DetailModel;
use App\Models\BukuModel;
use App\Models\PengembalianModel;
use App\Models\TransaksiModel;

class Peminjaman extends BaseController
{
    protected $peminjamanModel;
    protected $detailModel;
    protected $bukuModel;
    protected $pengembalianModel;
    protected $transaksiModel;
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();

        $this->peminjamanModel = new PeminjamanModel();
        $this->detailModel = new DetailModel();
        $this->bukuModel = new BukuModel();
        $this->pengembalianModel = new PengembalianModel();
        $this->transaksiModel = new TransaksiModel();
    }

    // ================= INDEX =================
    public function index()
    {
        $builder = $this->db->table('peminjaman');

        $builder->select('
            peminjaman.*,
            users.nama as nama_anggota,
            GROUP_CONCAT(buku.judul SEPARATOR ", ") as daftar_buku
        ')
        ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
        ->join('users', 'users.id = anggota.user_id', 'left')
        ->join('detail_peminjaman', 'detail_peminjaman.id_peminjaman = peminjaman.id_peminjaman', 'left')
        ->join('buku', 'buku.id_buku = detail_peminjaman.id_buku', 'left')
        ->groupBy('peminjaman.id_peminjaman');

        if (session()->get('role') == 'anggota') {
            $builder->where('peminjaman.id_anggota', session()->get('id_anggota'));
        }

        $data['peminjaman'] = $builder->get()->getResultArray();

        return view('peminjaman/index', $data);
    }

    // ================= CREATE =================
    public function create()
    {
        $data['rekomendasi'] = $this->bukuModel->findAll();
        $data['kategori_list'] = (new \App\Models\KategoriModel())->findAll();

        $data['anggota'] = $this->db->table('anggota')
            ->where('id_anggota', session()->get('id_anggota'))
            ->get()->getRowArray();

        return view('peminjaman/create', $data);
    }

    // ================= PINJAM (NO PETUGAS) =================
    public function pinjamMulti()
    {
        $id_anggota = session()->get('id_anggota');
        $buku = $this->request->getPost('buku');
        $metode = $this->request->getPost('metode_pengambilan');
        $alamat = $this->request->getPost('alamat');

        if (!$buku) {
            return redirect()->back()->with('error', 'Pilih buku');
        }

        // simpan peminjaman
        $this->peminjamanModel->insert([
            'id_anggota' => $id_anggota,
            'tanggal_pinjam' => date('Y-m-d'),
            'tanggal_kembali' => date('Y-m-d', strtotime('+7 days')),
            'status' => 'menunggu',
            'metode_pengambilan' => $metode,
            'alamat_pengantaran' => $alamat,
            'status_pengantaran' => ($metode == 'antar') ? 'menunggu_konfirmasi' : 'langsung'
        ]);

        $id_peminjaman = $this->peminjamanModel->insertID();

        foreach ($buku as $id_buku) {

            // detail
            $this->db->table('detail_peminjaman')->insert([
                'id_peminjaman' => $id_peminjaman,
                'id_buku' => $id_buku
            ]);

            // 🔻 stok berkurang
            $this->db->query("
                UPDATE buku 
                SET tersedia = tersedia - 1 
                WHERE id_buku = ?
            ", [$id_buku]);
        }

        return redirect()->to('/peminjaman');
    }
// ================= KEMBALI (STOK +1) =================
public function kembali($id)
{
    $detail = $this->db->table('detail_peminjaman')
        ->where('id_peminjaman', $id)
        ->get()
        ->getResultArray();

    foreach ($detail as $d) {

        // cek biar tidak minus/bug
        $this->db->query("
            UPDATE buku 
            SET tersedia = tersedia + 1 
            WHERE id_buku = ?
        ", [$d['id_buku']]);
    }

    $this->peminjamanModel->update($id, [
        'status' => 'kembali',
        'status_pengantaran' => null
    ]);

    return redirect()->to('/peminjaman')
        ->with('success', 'Buku berhasil dikembalikan');
}
// ================= KONFIRMASI AMBIL DI PERPUS =================
public function konfirmasiAmbilPerpus($id)
{
    $this->peminjamanModel->update($id, [
        'status' => 'dipinjam',
        'status_pengantaran' => 'selesai',
        'id_petugas' => session()->get('id_petugas')
    ]);

    return redirect()->back()->with('success', 'Peminjaman berhasil (dipinjam)');
}

// ================= KONFIRMASI ANTAR RUMAH =================
public function konfirmasiAntar($id)
{
    $id_petugas = session()->get('id_petugas');

    $this->peminjamanModel->update($id, [
        'status_pengantaran' => 'diproses',
        'id_petugas' => $id_petugas
    ]);

    return redirect()->back()->with('success', 'Pengantaran dikonfirmasi');
}

// ================= MULAI ANTAR =================
public function mulaiAntar($id)
{
    $this->peminjamanModel->update($id, [
        'status_pengantaran' => 'dalam_pengantaran'
    ]);

    return redirect()->back()->with('success', 'Pengantaran dimulai');
}

    // ================= SELESAI ANTAR =================
   public function selesai($id)
{
    $this->peminjamanModel->update($id, [
        'status_pengantaran' => 'selesai',
        'status' => 'dipinjam' // ✔ FINAL
    ]);

    return redirect()->back()->with('success', 'Buku sudah diterima (dipinjam aktif)');
}
    // ================= PENGAJUAN =================
    public function ajukanKembali($id)
    {
        $this->peminjamanModel->update($id, [
            'status_pengajuan' => 'kembali'
        ]);

        return redirect()->back()->with('success', 'Pengajuan pengembalian dikirim');
    }

    public function ajukanPerpanjang($id)
    {
        $this->peminjamanModel->update($id, [
            'status_pengajuan' => 'perpanjang'
        ]);

        return redirect()->back()->with('success', 'Pengajuan perpanjangan dikirim');
    }

    public function ajukanPenarikan($id)
    {
        $this->peminjamanModel->update($id, [
            'status_pengajuan' => 'penarikan'
        ]);

        return redirect()->back()->with('success', 'Pengajuan penarikan dikirim');
    }

    // ================= KONFIRMASI PENGAJUAN =================
    public function konfirmasiPengembalian($id)
    {
        $this->peminjamanModel->update($id, [
            'status' => 'kembali',
            'status_pengajuan' => null
        ]);

        return redirect()->back()->with('success', 'Pengembalian dikonfirmasi');
    }

    public function konfirmasiPerpanjangan($id)
    {
        $this->peminjamanModel->update($id, [
            'tanggal_kembali' => date('Y-m-d', strtotime('+3 days')),
            'status_pengajuan' => null
        ]);

        return redirect()->back()->with('success', 'Perpanjangan disetujui');
    }

    public function konfirmasiPenarikan($id)
    {
        $this->peminjamanModel->update($id, [
            'status_pengajuan' => null
        ]);

        return redirect()->back()->with('success', 'Penarikan diproses');
    }

    // ================= DETAIL =================
    public function detail($id)
    {
        $data['peminjaman'] = $this->db->table('peminjaman')
            ->select('peminjaman.*, users.nama as nama_anggota')
            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
            ->join('users', 'users.id = anggota.user_id', 'left')
            ->where('peminjaman.id_peminjaman', $id)
            ->get()
            ->getRowArray();

        if (!$data['peminjaman']) {
            return redirect()->to('/peminjaman')
                ->with('error', 'Data tidak ditemukan');
        }

        $data['buku'] = $this->db->table('detail_peminjaman')
            ->select('buku.judul')
            ->join('buku', 'buku.id_buku = detail_peminjaman.id_buku')
            ->where('detail_peminjaman.id_peminjaman', $id)
            ->get()
            ->getResultArray();

        return view('peminjaman/detail', $data);
    }

    // ================= DELETE =================
    public function delete($id)
    {
        $this->peminjamanModel->delete($id);

        return redirect()->to('/peminjaman')
            ->with('success', 'Data berhasil dihapus');
    }
}
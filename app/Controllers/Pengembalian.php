<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\PengembalianModel;
use App\Models\DendaModel;
use CodeIgniter\Controller;

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

    // ================= INDEX (Menghilangkan Space Kosong) =================
    public function index()
    {
        $builder = $this->db->table('pengembalian');
        $builder->select('
            pengembalian.id_pengembalian,
            pengembalian.tanggal_dikembalikan, 
            pengembalian.denda,
            pengembalian.status_bayar,
            peminjaman.tanggal_pinjam,
            peminjaman.tanggal_kembali as jatuh_tempo,
            users.nama as nama_anggota
        ')
        /* Inner Join memastikan hanya data yang memiliki relasi lengkap yang tampil */
        ->join('peminjaman', 'peminjaman.id_peminjaman = pengembalian.id_peminjaman')
        ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota')
        ->join('users', 'users.id = anggota.user_id')
        ->orderBy('pengembalian.tanggal_dikembalikan', 'DESC');

        if (session()->get('role') == 'anggota') {
            $builder->where('peminjaman.id_anggota', session()->get('id_anggota'));
        }

        $data['pengembalian'] = $builder->get()->getResultArray();
        return view('pengembalian/index', $data);
    }

    // ================= FORM CREATE (Fix Method Found) =================
    public function create($id_peminjaman)
    {
        $data['peminjaman'] = $this->peminjamanModel->find($id_peminjaman);

        if (!$data['peminjaman']) {
            return redirect()->to('/peminjaman')
                ->with('error', 'Data peminjaman tidak ditemukan');
        }

        return view('pengembalian/create', $data);
    }

    // ================= SIMPAN (Fix Status & Stock) =================
    public function simpan()
    {
        $id_peminjaman = $this->request->getPost('id_peminjaman');
        $denda         = $this->request->getPost('denda') ?? 0;

        // Ambil data peminjaman untuk tgl_kembali_asli
        $pinjam = $this->peminjamanModel->find($id_peminjaman);
        if (!$pinjam) {
            return redirect()->back()->with('error', 'Data peminjaman tidak valid');
        }

        $this->db->transStart();

        // 1. Simpan ke tabel pengembalian
        $this->pengembalianModel->insert([
            'id_peminjaman'        => $id_peminjaman,
            'tgl_kembali_asli'     => $pinjam['tanggal_kembali'] ?? null,
            'tanggal_dikembalikan' => date('Y-m-d H:i:s'), 
            'denda'                => $denda,
            'status_bayar'         => ($denda > 0) ? 'belum' : 'lunas'
        ]);

        // 2. Update status di tabel peminjaman ke 'kembali' (Sesuai ENUM database)
        $this->peminjamanModel->update($id_peminjaman, [
            'status'           => 'kembali',
            'status_pengajuan' => null
        ]);

        // 3. Kembalikan stok buku
        $detail = $this->db->table('detail_peminjaman')->where('id_peminjaman', $id_peminjaman)->get()->getResultArray();
        foreach ($detail as $d) {
            $this->db->table('buku')
                ->where('id_buku', $d['id_buku'])
                ->set('tersedia', 'tersedia + 1', false)
                ->update();
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal memproses pengembalian');
        }

        return redirect()->to('/pengembalian')->with('success', 'Buku berhasil dikembalikan');
    }

    // ================= KONFIRMASI (Untuk Petugas) =================
    public function konfirmasiPengembalian($id)
    {
        $this->peminjamanModel->update($id, [
            'status'           => 'kembali', 
            'status_pengajuan' => null
        ]);

        return redirect()->to('/pengembalian')
            ->with('success', 'Data pengembalian berhasil dikonfirmasi');
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

        return view('pengembalian/bayar', ['p' => $p]);
    }
}
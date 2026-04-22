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

    // ================= HITUNG ONGKIR =================
    private function hitungOngkir($alamat)
    {
        $alamat = strtolower($alamat);

        if (str_contains($alamat, 'dekat')) {
            return 5000;
        } elseif (str_contains($alamat, 'sedang')) {
            return 10000;
        } else {
            return 15000;
        }
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
        $data['rekomendasi'] = $this->bukuModel->orderBy('id_buku', 'RANDOM')->limit(5)->findAll();

        $kategoriModel = new \App\Models\KategoriModel();
        $data['kategori_list'] = $kategoriModel->findAll();

        $data['anggota'] = $this->db->table('anggota')
            ->where('id_anggota', session()->get('id_anggota'))
            ->get()->getRowArray();

        $data['petugas'] = $this->db->table('petugas p')
            ->select('p.id_petugas, p.jabatan, u.nama')
            ->join('users u', 'u.id = p.user_id')
            ->get()->getResultArray();

        return view('peminjaman/create', $data);
    }


    public function detail($id)
{
    $db = \Config\Database::connect();

    // =========================
    // DATA PEMINJAMAN UTAMA
    // =========================
    $peminjaman = $db->table('peminjaman pm')
        ->select('
            pm.*,
            u1.nama as nama_anggota,
            u2.nama as nama_petugas
        ')
        ->join('anggota a', 'a.id_anggota = pm.id_anggota', 'left')
        ->join('users u1', 'u1.id = a.user_id', 'left')
        ->join('petugas p', 'p.id_petugas = pm.id_petugas', 'left')
        ->join('users u2', 'u2.id = p.user_id', 'left')
        ->where('pm.id_peminjaman', $id)
        ->get()
        ->getRowArray();

    // =========================
    // CEK DATA ADA / TIDAK
    // =========================
    if (!$peminjaman) {
        return redirect()->to('/peminjaman')
            ->with('error', 'Data peminjaman tidak ditemukan');
    }

    // =========================
    // DETAIL BUKU DIPINJAM
    // =========================
    $buku = $db->table('detail_peminjaman dp')
        ->select('b.judul, dp.jumlah')
        ->join('buku b', 'b.id_buku = dp.id_buku')
        ->where('dp.id_peminjaman', $id)
        ->get()
        ->getResultArray();

    // =========================
    // RETURN VIEW
    // =========================
    return view('peminjaman/detail', [
        'peminjaman' => $peminjaman,
        'buku' => $buku
    ]);
}
    // ================= PINJAM =================
    public function pinjamMulti()
    {
        $id_petugas = $this->request->getPost('id_petugas');
        $id_anggota = session()->get('id_anggota');
        $buku = $this->request->getPost('buku');
        $metode = $this->request->getPost('metode_pengambilan');
        $alamat = $this->request->getPost('alamat');

        if (!$buku) {
            return redirect()->back()->with('error', 'Pilih buku dulu');
        }

        if (count($buku) > 2) {
            return redirect()->back()->with('error', 'Maksimal 2 buku');
        }

        if ($metode == 'antar' && empty($alamat)) {
            return redirect()->back()->with('error', 'Alamat wajib diisi');
        }

        // ================= STATUS AWAL FIX =================
        if ($metode == 'antar') {
            $status_pengantaran = 'menunggu_pembayaran'; // ✔ FIX UTAMA
            $id_petugas = null;
        } else {
            $status_pengantaran = 'diambil_langsung';
        }

        $this->peminjamanModel->insert([
            'id_anggota' => $id_anggota,
            'id_petugas' => $id_petugas,
            'tanggal_pinjam' => date('Y-m-d'),
            'tanggal_kembali' => date('Y-m-d', strtotime('+7 days')),
            'status' => 'menunggu',
            'metode_pengambilan' => $metode,
            'alamat_pengantaran' => ($metode == 'antar') ? $alamat : null,
            'status_pengantaran' => $status_pengantaran
        ]);

        $id_peminjaman = $this->peminjamanModel->insertID();

        foreach ($buku as $id_buku) {
            $dataBuku = $this->bukuModel->find($id_buku);

            if ($dataBuku && $dataBuku['tersedia'] > 0) {
                $this->detailModel->insert([
                    'id_peminjaman' => $id_peminjaman,
                    'id_buku' => $id_buku,
                    'jumlah' => 1
                ]);

                $this->bukuModel->update($id_buku, [
                    'tersedia' => $dataBuku['tersedia'] - 1
                ]);
            }
        }

        return redirect()->to('/peminjaman')->with('success', 'Berhasil pinjam buku');
    }
public function pembayaran($id)
{
    $peminjaman = $this->peminjamanModel->find($id);

    if (!$peminjaman) {
        return redirect()->to('/peminjaman')->with('error', 'Data tidak ditemukan');
    }

    // cek transaksi ongkir
    $transaksi = $this->transaksiModel
        ->where('id_peminjaman', $id)
        ->where('jenis', 'ongkir')
        ->first();

    $ongkir = 10000;

    if (!$transaksi) {
        $this->transaksiModel->insert([
            'id_peminjaman' => $id,
            'jenis' => 'ongkir',
            'jumlah' => $ongkir,
            'status' => 'pending',
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        $id_transaksi = $this->transaksiModel->insertID();
    } else {
        $id_transaksi = $transaksi['id_transaksi'];
        $ongkir = $transaksi['jumlah'];
    }

    $dataQR = json_encode([
        'id_transaksi' => $id_transaksi,
        'nominal' => $ongkir
    ]);

    return view('peminjaman/pembayaran', [
        'peminjaman' => $peminjaman,
        'ongkir' => $ongkir,
        'dataQR' => $dataQR,
        'id_transaksi' => $id_transaksi
    ]);
}
    // ================= BAYAR =================
    public function prosesBayar($id_transaksi)
    {
        $file = $this->request->getFile('bukti');

        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'Bukti wajib diupload');
        }

        $namaFile = $file->getRandomName();
        $file->move('uploads/bukti', $namaFile);

        $transaksi = $this->transaksiModel->find($id_transaksi);

        $this->transaksiModel->update($id_transaksi, [
            'bukti_bayar' => $namaFile,
            'status' => 'menunggu_verifikasi'
        ]);

        // ✔ STATUS FIX
        $this->peminjamanModel->update($transaksi['id_peminjaman'], [
            'status_pengantaran' => 'menunggu_konfirmasi'
        ]);

        return redirect()->to('/peminjaman')
            ->with('success', 'Bukti pembayaran berhasil dikirim');
    }

    // ================= KONFIRMASI PETUGAS =================
    public function konfirmasi($id)
    {
        $this->peminjamanModel->update($id, [
            'status_pengantaran' => 'siap_diantar',
            'id_petugas' => session()->get('id_petugas')
        ]);

        return redirect()->to('/peminjaman')->with('success', 'Dikonfirmasi');
    }

    // ================= MULAI ANTAR =================
    public function mulaiAntar($id)
    {
        $this->peminjamanModel->update($id, [
            'status_pengantaran' => 'dalam_pengantaran'
        ]);

        return redirect()->to('/peminjaman');
    }

    // ================= SELESAI ANTAR =================
    public function selesai($id)
    {
        $this->peminjamanModel->update($id, [
            'status_pengantaran' => 'selesai',
            'status' => 'dipinjam'
        ]);

        return redirect()->to('/peminjaman');
    }

    // ================= KEMBALI =================
    public function kembali($id)
    {
        $peminjaman = $this->peminjamanModel->find($id);

        $tanggal_kembali = date('Y-m-d');

        $batas = strtotime($peminjaman['tanggal_kembali']);
        $kembali = strtotime($tanggal_kembali);

        $denda = 0;
        if ($kembali > $batas) {
            $denda = (($kembali - $batas) / 86400) * 15000;
        }

        $this->peminjamanModel->update($id, [
            'status' => 'kembali'
        ]);

        $buku = $this->detailModel->where('id_peminjaman', $id)->findAll();

        foreach ($buku as $b) {
            $dataBuku = $this->bukuModel->find($b['id_buku']);

            if ($dataBuku) {
                $this->bukuModel->update($b['id_buku'], [
                    'tersedia' => $dataBuku['tersedia'] + 1
                ]);
            }
        }

        $this->db->table('pengembalian')->insert([
            'id_peminjaman' => $id,
            'tanggal_dikembalikan' => $tanggal_kembali,
            'denda' => $denda
        ]);

        return redirect()->to('/peminjaman')->with('success', 'Buku dikembalikan');
    }
}
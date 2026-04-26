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
        }
        return 15000;
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
        $data['hasil_cari'] = [];
        $data['rekomendasi'] = $this->bukuModel->orderBy('id_buku', 'RANDOM')->findAll();

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

    // ================= PINJAM =================
    public function pinjamMulti()
    {
        $id_petugas = $this->request->getPost('id_petugas');
        $id_anggota = session()->get('id_anggota');
        $buku = $this->request->getPost('buku');
        $metode = $this->request->getPost('metode_pengambilan');
        $alamat = $this->request->getPost('alamat');

        if (!$buku) return redirect()->back()->with('error', 'Pilih buku');

        if ($metode == 'antar') {
            $status_pengantaran = 'menunggu_pembayaran';
            $id_petugas = null;
        } else {
            if (!$id_petugas) return redirect()->back()->with('error', 'Pilih petugas');
            $status_pengantaran = 'diambil_langsung';
        }

        $this->peminjamanModel->insert([
            'id_anggota' => $id_anggota,
            'id_petugas' => $id_petugas,
            'tanggal_pinjam' => date('Y-m-d'),
            'tanggal_kembali' => date('Y-m-d', strtotime('+7 days')),
            'status' => 'menunggu',
            'metode_pengambilan' => $metode,
            'alamat_pengantaran' => $alamat,
            'status_pengantaran' => $status_pengantaran
        ]);

        $id_peminjaman = $this->peminjamanModel->insertID();

        foreach ($buku as $id_buku) {
            $this->detailModel->insert([
                'id_peminjaman' => $id_peminjaman,
                'id_buku' => $id_buku,
                'jumlah' => 1
            ]);
        }

        return redirect()->to('/peminjaman');
    }

    // ================= PEMBAYARAN =================
    public function pembayaran($id)
    {
        $peminjaman = $this->peminjamanModel->find($id);

        if (!$peminjaman) {
            return redirect()->to('/peminjaman')->with('error', 'Data tidak ditemukan');
        }

        $ongkir = $this->hitungOngkir($peminjaman['alamat_pengantaran']);

        // 🔥 transaksi (anti dobel)
        $transaksi = $this->transaksiModel
            ->where('id_peminjaman', $id)
            ->where('jenis', 'ongkir')
            ->first();

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

    // ================= PROSES BAYAR =================
  public function prosesBayar($id_transaksi)
{
    $file = $this->request->getFile('bukti');

    if (!$file || !$file->isValid()) {
        return redirect()->back()->with('error', 'Bukti wajib diupload');
    }

    if (!in_array($file->getExtension(), ['jpg','jpeg','png'])) {
        return redirect()->back()->with('error', 'Format harus JPG/PNG');
    }

    // simpan file
    $namaFile = $file->getRandomName();
    $file->move('uploads/bukti', $namaFile);

    // ambil transaksi
    $transaksi = $this->transaksiModel->find($id_transaksi);

    if (!$transaksi) {
        return redirect()->back()->with('error', 'Transaksi tidak ditemukan');
    }

    // update transaksi
    $this->transaksiModel->update($id_transaksi, [
        'bukti_bayar' => $namaFile,
        'status' => 'menunggu_verifikasi'
    ]);

    // 🔥 INI YANG KAMU LUPA (UPDATE PEMINJAMAN)
    $this->peminjamanModel->update($transaksi['id_peminjaman'], [
        'status' => 'diproses', // atau "dibayar"
        'status_pengantaran' => 'menunggu_konfirmasi'
    ]);

    return redirect()->to('/peminjaman')
        ->with('success', 'Bukti pembayaran berhasil dikirim');
}
    // ================= KONFIRMASI ANTAR =================
    public function konfirmasi($id)
    {
        $this->peminjamanModel->update($id, [
            'status_pengantaran' => 'siap_diantar'
        ]);

        return redirect()->back();
    }

    public function mulaiAntar($id)
    {
        $this->peminjamanModel->update($id, [
            'status_pengantaran' => 'dalam_pengantaran'
        ]);

        return redirect()->back();
    }

    public function selesai($id)
    {
        $this->peminjamanModel->update($id, [
            'status_pengantaran' => 'selesai',
            'status' => 'dipinjam'
        ]);

        return redirect()->back();
    }

    // ================= PENGAJUAN =================
    public function ajukanKembali($id)
    {
        $this->peminjamanModel->update($id, [
            'status_pengajuan' => 'kembali'
        ]);
        return redirect()->back();
    }

    public function ajukanPerpanjang($id)
    {
        $this->peminjamanModel->update($id, [
            'status_pengajuan' => 'perpanjang'
        ]);
        return redirect()->back();
    }

    public function ajukanPenarikan($id)
    {
        $this->peminjamanModel->update($id, [
            'status_pengajuan' => 'penarikan'
        ]);
        return redirect()->back();
    }

    // ================= KONFIRMASI PENGAJUAN =================
    public function konfirmasiPengembalian($id)
    {
        $this->peminjamanModel->update($id, [
            'status' => 'kembali',
            'status_pengajuan' => null
        ]);
        return redirect()->back();
    }

    public function konfirmasiPerpanjangan($id)
    {
        $this->peminjamanModel->update($id, [
            'tanggal_kembali' => date('Y-m-d', strtotime('+3 days')),
            'status_pengajuan' => null
        ]);
        return redirect()->back();
    }

    public function konfirmasiPenarikan($id)
    {
        $this->peminjamanModel->update($id, [
            'status_pengajuan' => null
        ]);
        return redirect()->back();
    }

    // ================= DELETE =================
    public function delete($id)
    {
        $this->peminjamanModel->delete($id);
        return redirect()->to('/peminjaman');
    }

    // ================= KEMBALI =================
    public function kembali($id)
    {
        $this->peminjamanModel->update($id, [
            'status' => 'kembali'
        ]);

        return redirect()->to('/peminjaman');
    }
}
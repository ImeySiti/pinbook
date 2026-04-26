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
        ->groupBy('peminjaman.id_peminjaman')
        ->orderBy('peminjaman.id_peminjaman', 'DESC');

        if (session()->get('role') == 'anggota') {
            $builder->where('peminjaman.id_anggota', session()->get('id_anggota'));
        }

        $data['peminjaman'] = $builder->get()->getResultArray();
        return view('peminjaman/index', $data);
    }

    // ================= CREATE =================
    public function create()
    {
        $search   = $this->request->getGet('q');
        $kategori = $this->request->getGet('kategori');

        $bukuBuilder = $this->db->table('buku');
        $bukuBuilder->where('tersedia >', 0);
        
        if ($search) {
            $bukuBuilder->like('judul', $search);
        }
        if ($kategori) {
            $bukuBuilder->where('id_kategori', $kategori);
        }
        
        $buku_list = $bukuBuilder->get()->getResultArray();
        $kategori_list = $this->db->table('kategori')->get()->getResultArray();
        $rekomendasi = $this->db->table('buku')
                            ->where('tersedia >', 0)
                            ->orderBy('RAND()') 
                            ->limit(3)
                            ->get()
                            ->getResultArray();

        $data = [
            'title'         => 'Tambah Peminjaman Buku',
            'buku'          => $buku_list,
            'kategori_list' => $kategori_list,
            'rekomendasi'   => $rekomendasi 
        ];

        return view('peminjaman/create', $data);
    }

    // ================= PINJAM MULTI =================
    public function pinjamMulti()
    {
        $id_anggota = session()->get('id_anggota');
        $buku       = $this->request->getPost('buku');
        $metode     = $this->request->getPost('metode_pengambilan');
        $alamat     = $this->request->getPost('alamat');

        if (!$buku) {
            return redirect()->back()->with('error', 'Silakan pilih minimal satu buku.');
        }

        $this->db->transStart();

        $this->peminjamanModel->insert([
            'id_anggota'         => $id_anggota,
            'tanggal_pinjam'     => date('Y-m-d'),
            'tanggal_kembali'    => date('Y-m-d', strtotime('+7 days')),
            'status'             => 'menunggu',
            'metode_pengambilan' => $metode,
            'alamat_pengantaran' => $alamat,
            'status_pengantaran' => ($metode == 'antar') ? 'menunggu_konfirmasi' : 'langsung'
        ]);

        $id_peminjaman = $this->peminjamanModel->insertID();

        foreach ($buku as $id_buku) {
            $this->db->table('detail_peminjaman')->insert([
                'id_peminjaman' => $id_peminjaman,
                'id_buku'       => $id_buku
            ]);

            $this->db->table('buku')
                ->where('id_buku', $id_buku)
                ->set('tersedia', 'tersedia - 1', false)
                ->update();
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal memproses peminjaman.');
        }

        return redirect()->to('/peminjaman')->with('success', 'Peminjaman berhasil diajukan.');
    }

    // ================= KEMBALI =================
    public function kembali($id)
    {
        $pinjam = $this->peminjamanModel->find($id);
        if (!$pinjam) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $this->db->transStart();

        $detail = $this->db->table('detail_peminjaman')->where('id_peminjaman', $id)->get()->getResultArray();
        foreach ($detail as $d) {
            $this->db->table('buku')
                ->where('id_buku', $d['id_buku'])
                ->set('tersedia', 'tersedia + 1', false)
                ->update();
        }

        $this->pengembalianModel->insert([
            'id_peminjaman'        => $id,
            'tanggal_dikembalikan' => date('Y-m-d H:i:s'),
            'denda'                => 0,
            'status_bayar'         => 'lunas'
        ]);

        $this->peminjamanModel->update($id, [
            'status'           => 'kembali',
            'status_pengajuan' => null
        ]);

        $this->db->transComplete();

        return redirect()->to('/peminjaman')->with('success', 'Buku telah dikembalikan.');
    }

    // ================= KONFIRMASI PEMINJAMAN =================
    public function konfirmasiPeminjaman($id)
    {
        $pinjam = $this->peminjamanModel->find($id);

        if (!$pinjam) {
            return redirect()->back()->with('error', 'Data peminjaman tidak ditemukan.');
        }

        // Ambil ID dari session, pastikan key 'id_user' atau 'id' sesuai dengan session login Anda
        $id_petugas = session()->get('id_user') ?? session()->get('id');

        $dataUpdate = [
            'status'     => 'dipinjam',
            'id_petugas' => $id_petugas 
        ];

        if ($this->peminjamanModel->update($id, $dataUpdate)) {
            return redirect()->to('/peminjaman')->with('success', 'Peminjaman berhasil dikonfirmasi.');
        } else {
            return redirect()->back()->with('error', 'Gagal mengonfirmasi peminjaman.');
        }
    }
    // 1. Konfirmasi bahwa petugas akan mengantar buku (Setelah pembayaran divalidasi)
public function konfirmasiAntar($id)
{
    $update = $this->peminjamanModel->update($id, [
        'status_pengantaran' => 'siap_diantar',
        'id_petugas'         => session()->get('id_user')
    ]);

    if ($update) {
        return redirect()->to('/peminjaman')->with('success', 'Status: Buku siap diantar.');
    }
    return redirect()->back()->with('error', 'Gagal memproses konfirmasi antar.');
}

// 2. Update status saat petugas mulai berangkat mengantar
public function mulaiAntar($id)
{
    $this->peminjamanModel->update($id, [
        'status_pengantaran' => 'dalam_pengantaran'
    ]);

    return redirect()->to('/peminjaman')->with('success', 'Status: Dalam pengantaran.');
}
// Tambahkan atau pastikan method ini ada di dalam class Peminjaman
public function pembayaran($id)
{
    // 1. Cari data peminjaman berdasarkan ID
    $peminjaman = $this->peminjamanModel->find($id);

    if (!$peminjaman) {
        return redirect()->to('/peminjaman')->with('error', 'Data tidak ditemukan.');
    }

    // 2. Siapkan data untuk View (samakan dengan variabel di pembayaran.php)
    $data = [
        'title'        => 'Pembayaran Pengantaran',
        'peminjaman'   => $peminjaman,
        'id_transaksi' => $id,
        'ongkir'       => 5000, // Anda bisa menggantinya dengan data dari database jika ada
        'dataQR'       => "PAYMENT-LIB-" . $id // Data untuk isi QR Code
    ];

    // 3. Arahkan ke file view pembayaran.php
    return view('peminjaman/pembayaran', $data);
}

// Tambahkan juga method prosesBayar jika belum ada untuk menangani upload
public function prosesBayar($id)
{
    $fileBukti = $this->request->getFile('bukti');

    if ($fileBukti->isValid() && !$fileBukti->hasMoved()) {
        $namaBaru = $fileBukti->getRandomName();
        $fileBukti->move('uploads/bukti_bayar', $namaBaru);

        // Update status pengantaran menjadi 'sudah_bayar'
        $this->peminjamanModel->update($id, [
            'status_pengantaran' => 'sudah_bayar'
        ]);

        return redirect()->to('/peminjaman')->with('success', 'Bukti berhasil diunggah. Menunggu konfirmasi petugas.');
    }

    return redirect()->back()->with('error', 'Gagal mengunggah bukti.');
}

// 3. Update status saat buku sudah sampai di tangan anggota
public function selesai($id)
{
    $this->peminjamanModel->update($id, [
        'status_pengantaran' => 'selesai',
        'status'             => 'dipinjam' // Status utama berubah dari 'menunggu' ke 'dipinjam'
    ]);

    return redirect()->to('/peminjaman')->with('success', 'Pengantaran selesai. Buku telah diterima.');
}

}
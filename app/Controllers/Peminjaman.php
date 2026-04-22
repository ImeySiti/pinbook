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

        $filter = $this->request->getGet('filter_pengantaran');

        $builder->select('
            peminjaman.*,
            users.nama as nama_anggota,
            GROUP_CONCAT(buku.judul SEPARATOR ", ") as daftar_buku
        ')
        ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
        ->join('users', 'users.id = anggota.user_id', 'left')
        ->join('detail_peminjaman', 'detail_peminjaman.id_peminjaman = peminjaman.id_peminjaman', 'left')
        ->join('buku', 'buku.id_buku = detail_peminjaman.id_buku', 'left');

        if (session()->get('role') == 'anggota') {
            $builder->where('peminjaman.id_anggota', session()->get('id_anggota'));
        }

        if ($filter) {
            if ($filter == 'ambil') {
                $builder->where('peminjaman.metode_pengambilan', 'ambil');
            }
            if ($filter == 'antar') {
                $builder->where('peminjaman.metode_pengambilan', 'antar');
            }
            if ($filter == 'selesai') {
                $builder->where('peminjaman.status_pengantaran', 'selesai');
            }
            if ($filter == 'proses') {
                $builder->where('peminjaman.metode_pengambilan', 'antar');
                $builder->where('peminjaman.status_pengantaran !=', 'selesai');
            }
            if ($filter == 'konfirmasi') {
                $builder->where('peminjaman.status_pengantaran', 'menunggu_konfirmasi');
            }
        }

        $builder->groupBy('peminjaman.id_peminjaman');

        $data['peminjaman'] = $builder->get()->getResultArray();

        return view('peminjaman/index', $data);
    }

    // ================= CREATE =================
   public function create()
{
    $q = $this->request->getGet('q');
    $kategori = $this->request->getGet('kategori');

    $builder = $this->bukuModel;

    if ($q) $builder = $builder->like('judul', $q);
    if ($kategori) $builder = $builder->where('id_kategori', $kategori);

    $data['hasil_cari'] = ($q || $kategori) ? $builder->findAll() : [];

    $data['rekomendasi'] = $this->bukuModel
        ->orderBy('id_buku', 'RANDOM')
        ->limit(6)
        ->findAll();

    // kategori
    $kategoriModel = new \App\Models\KategoriModel();
    $data['kategori_list'] = $kategoriModel->findAll();

    // anggota
    $data['anggota'] = $this->db->table('anggota')
        ->where('id_anggota', session()->get('id_anggota'))
        ->get()->getRowArray();

    // 🔥 FIX PETUGAS
    $data['petugas'] = $this->db->table('petugas p')
        ->select('p.id_petugas, p.jabatan, u.nama')
        ->join('users u', 'u.id = p.user_id')
        ->get()
        ->getResultArray();

    return view('peminjaman/create', $data);
}

    // ================= ISI DATA (FIX 404) =================
    public function isiData()
    {
        $data['anggota'] = $this->db->table('anggota')
            ->where('id_anggota', session()->get('id_anggota'))
            ->get()->getRowArray();

        return view('anggota/isiData', $data);
    }

    public function simpanData()
    {
        $id = session()->get('id_anggota');

        $this->db->table('anggota')
            ->where('id_anggota', $id)
            ->update([
                'nis' => $this->request->getPost('nis'),
                'alamat' => $this->request->getPost('alamat'),
                'no_hp' => $this->request->getPost('no_hp')
            ]);

        return redirect()->to('/peminjaman/create')
            ->with('success', 'Data berhasil disimpan');
    }

    
    // ================= PINJAM =================
   public function pinjamMulti()
{
    $id_anggota = session()->get('id_anggota');

    // ================= CEK DATA ANGGOTA =================
    $anggota = $this->db->table('anggota')
        ->where('id_anggota', $id_anggota)
        ->get()
        ->getRowArray();

    if (
        empty($anggota['nis']) ||
        empty($anggota['alamat']) ||
        empty($anggota['no_hp'])
    ) {
        return redirect()->to('/anggota/isiData')
            ->with('error', 'Lengkapi data diri dulu sebelum meminjam buku');
    }

    // ================= DATA FORM =================
    $buku = $this->request->getPost('buku');
    $metode = $this->request->getPost('metode_pengambilan');
    $alamat = $this->request->getPost('alamat');

    if (!$buku) {
        return redirect()->back()->with('error', 'Pilih buku dulu');
    }

    // ================= STATUS =================
    $status = ($metode == 'antar') ? 'menunggu' : 'dipinjam';
    $status_pengantaran = ($metode == 'antar') ? 'menunggu_pembayaran' : 'diambil_langsung';

    // ================= INSERT PEMINJAMAN =================
    $this->peminjamanModel->insert([
        'id_anggota' => $id_anggota,
        'id_petugas' => 1,
        'tanggal_pinjam' => date('Y-m-d'),
        'tanggal_kembali' => date('Y-m-d', strtotime('+7 days')),
        'status' => $status,
        'metode_pengambilan' => $metode,
        'alamat_pengantaran' => $alamat,
        'status_pengantaran' => $status_pengantaran
    ]);

    $id_peminjaman = $this->peminjamanModel->insertID();

    // ================= DETAIL BUKU =================
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

    return redirect()->to('/peminjaman')
        ->with('success', 'Berhasil pinjam');
}

public function prosesBayar($id)
{
    $peminjaman = $this->peminjamanModel->find($id);

    if (!$peminjaman) {
        return redirect()->to('/peminjaman')
            ->with('error', 'Peminjaman tidak ditemukan');
    }

    $file = $this->request->getFile('bukti');

    if (!$file || !$file->isValid()) {
        return redirect()->back()->with('error', 'File tidak valid');
    }

    $namaFile = $file->getRandomName();
    $file->move('uploads/bukti', $namaFile);

    // ================= SIMPAN TRANSAKSI =================
    $this->transaksiModel->insert([
        'id_peminjaman' => $id,
        'bukti' => $namaFile,
        'status' => 'menunggu_konfirmasi'
    ]);

    // ================= UPDATE STATUS PEMINJAMAN (INI FIX UTAMA) =================
    $this->peminjamanModel->update($id, [
        'status' => 'diproses',
        'status_pengantaran' => 'menunggu_konfirmasi'
    ]);

    return redirect()->to('/peminjaman')
        ->with('success', 'Menunggu konfirmasi petugas');
}
public function bayarView($id)
{
    $peminjaman = $this->peminjamanModel->find($id);

    if (!$peminjaman) {
        return redirect()->to('/peminjaman')
            ->with('error', 'Data tidak ditemukan');
    }

    return view('peminjaman/pembayaran', [
        'peminjaman' => $peminjaman,
        'ongkir' => 15000,
        'dataQR' => 'bayar-' . $id
    ]);
    
}
    // ================= DETAIL =================
    public function detail($id)
    {
        $db = \Config\Database::connect();

        $peminjaman = $db->table('peminjaman pm')
            ->select('pm.*, u1.nama as nama_anggota, u2.nama as nama_petugas')
            ->join('anggota a', 'a.id_anggota = pm.id_anggota', 'left')
            ->join('users u1', 'u1.id = a.user_id', 'left')
            ->join('petugas p', 'p.id_petugas = pm.id_petugas', 'left')
            ->join('users u2', 'u2.id = p.user_id', 'left')
            ->where('pm.id_peminjaman', $id)
            ->get()->getRowArray();

        return view('peminjaman/detail', [
            'peminjaman' => $peminjaman
        ]);
    }

    // ================= KEMBALI =================
    public function kembali($id)
    {
        $this->peminjamanModel->update($id, [
            'status' => 'kembali'
        ]);

        return redirect()->to('/peminjaman')
            ->with('success', 'Buku dikembalikan');
    }
}
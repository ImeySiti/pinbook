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

    // ================= PINJAM =================
    public function pinjamMulti()
    {
        $id_anggota = session()->get('id_anggota');

        $anggota = $this->db->table('anggota')
            ->where('id_anggota', $id_anggota)
            ->get()->getRowArray();

        if (
            empty($anggota['nis']) ||
            empty($anggota['alamat']) ||
            empty($anggota['no_hp'])
        ) {
            return redirect()->to('/anggota/isiData')
                ->with('error', 'Lengkapi data diri dulu');
        }

        $buku = $this->request->getPost('buku');
        $metode = $this->request->getPost('metode_pengambilan');
        $alamat = $this->request->getPost('alamat');

        if (!$buku) {
            return redirect()->back()->with('error', 'Pilih buku dulu');
        }

        // 🔥 FIX FLOW AWAL
        if ($metode == 'antar') {
            $status = 'menunggu_pembayaran';
            $status_pengantaran = 'menunggu_pembayaran';
        } else {
            $status = 'dipinjam';
            $status_pengantaran = 'tidak_antar';
        }

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
public function detail($id)
{
    $db = \Config\Database::connect();

    // =========================
    // DETAIL PEMINJAMAN
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
    // BUKU YANG DIPINJAM
    // =========================
    $buku = $db->table('detail_peminjaman dp')
        ->select('b.judul')
        ->join('buku b', 'b.id_buku = dp.id_buku')
        ->where('dp.id_peminjaman', $id)
        ->get()
        ->getResultArray();

    return view('peminjaman/detail', [
        'peminjaman' => $peminjaman,
        'buku' => $buku
    ]);
}
    // ================= BAYAR =================
    public function prosesBayar($id)
    {
        $file = $this->request->getFile('bukti');

        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid');
        }

        $namaFile = $file->getRandomName();
        $file->move('uploads/bukti', $namaFile);

        $this->transaksiModel->insert([
            'id_peminjaman' => $id,
            'bukti' => $namaFile,
            'status' => 'menunggu_konfirmasi'
        ]);

        // 🔥 INI YANG BENAR (FIX UTAMA KAMU)
        $this->peminjamanModel->update($id, [
            'status' => 'menunggu_konfirmasi',
            'status_pengantaran' => 'menunggu_konfirmasi'
        ]);

        return redirect()->to('/peminjaman')
            ->with('success', 'Menunggu konfirmasi petugas');
    }

    public function bayarView($id)
    {
        $p = $this->peminjamanModel->find($id);

        if (!$p) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        return view('peminjaman/pembayaran', [
            'peminjaman' => $p
        ]);
    }

    // ================= FLOW ANTAR =================
    public function konfirmasi($id)
    {
        $this->peminjamanModel->update($id, [
            'status_pengantaran' => 'siap_diantar'
        ]);

        return redirect()->to('/peminjaman');
    }

    public function mulaiAntar($id)
    {
        $this->peminjamanModel->update($id, [
            'status_pengantaran' => 'dalam_pengantaran',
            'status' => 'dipinjam'
        ]);

        return redirect()->to('/peminjaman');
    }

    public function selesai($id)
    {
        $this->peminjamanModel->update($id, [
            'status_pengantaran' => 'selesai'
        ]);

        return redirect()->to('/peminjaman');
    }
    //print
    public function print()
{
    $data['peminjaman'] = $this->db->table('peminjaman p')
        ->select('p.*, u.nama as nama_anggota')
        ->join('anggota a', 'a.id_anggota = p.id_anggota', 'left')
        ->join('users u', 'u.id = a.user_id', 'left')
        ->orderBy('p.id_peminjaman', 'DESC')
        ->get()->getResultArray();

    return view('peminjaman/print', $data);
}
// wa
public function wa($id)
{
    $p = $this->db->table('peminjaman p')
        ->select('p.*, u.nama as nama_anggota, a.no_hp')
        ->join('anggota a', 'a.id_anggota = p.id_anggota', 'left')
        ->join('users u', 'u.id = a.user_id', 'left')
        ->where('p.id_peminjaman', $id)
        ->get()->getRowArray();

    if (!$p) {
        return redirect()->to('/peminjaman');
    }

    // ambil nomor asli
    $no = preg_replace('/^0/', '62', $p['no_hp']);

    $pesan = "DATA PEMINJAMAN\n\n";
    $pesan .= "Nama: " . ($p['nama_anggota'] ?? '-') . "\n";
    $pesan .= "Tanggal Pinjam: " . $p['tanggal_pinjam'] . "\n";
    $pesan .= "Tanggal Kembali: " . $p['tanggal_kembali'] . "\n";
    $pesan .= "Status: " . $p['status'] . "\n";
    $pesan .= "Metode: " . $p['metode_pengambilan'] . "\n";

    return redirect()->to("https://wa.me/" . $no . "?text=" . urlencode($pesan));
}
//kembali
    public function kembali($id)
    {
        $this->peminjamanModel->update($id, [
            'status' => 'kembali'
        ]);

        return redirect()->to('/peminjaman')
            ->with('success', 'Buku dikembalikan');
    }
    
}
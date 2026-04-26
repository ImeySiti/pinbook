<?php

namespace App\Controllers;

use App\Models\BukuModel;
use App\Models\KategoriModel;
use App\Models\PenulisModel;
use App\Models\PenerbitModel;
use App\Models\RakModel;

class Buku extends BaseController
{
    protected $bukuModel;
    protected $db;

    public function __construct()
    {
        $this->bukuModel = new BukuModel();
        $this->db = \Config\Database::connect(); // ✅ FIX PENTING
    }

    // ================= INDEX =================
    public function index()
    {
        $keyword  = $this->request->getGet('keyword');
        $kategori = $this->request->getGet('kategori');

        $builder = $this->bukuModel
            ->select('buku.*, kategori.nama_kategori, penulis.nama_penulis, penerbit.nama_penerbit, rak.nama_rak, rak.lokasi')
            ->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left')
            ->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left')
            ->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left')
            ->join('buku_rak', 'buku_rak.id_buku = buku.id_buku', 'left')
            ->join('rak', 'rak.id_rak = buku_rak.id_rak', 'left');

        if ($keyword) {
            $builder->groupStart()
                ->like('buku.judul', $keyword)
                ->orLike('buku.isbn', $keyword)
            ->groupEnd();
        }

        if ($kategori) {
            $builder->where('buku.id_kategori', $kategori);
        }

        return view('buku/index', [
            'buku'     => $builder->paginate(10),
            'pager'    => $this->bukuModel->pager,
            'kategori' => (new KategoriModel())->findAll()
        ]);
    }

    // ================= CREATE =================
    public function create()
    {
        return view('buku/create', [
            'kategori' => (new KategoriModel())->findAll(),
            'penulis'  => (new PenulisModel())->findAll(),
            'penerbit' => (new PenerbitModel())->findAll(),
            'rak'      => (new RakModel())->findAll(),
        ]);
    }

    // ================= STORE =================
    public function store()
    {
        $kategoriModel = new KategoriModel();
        $penulisModel  = new PenulisModel();
        $penerbitModel = new PenerbitModel();

        $id_kategori = $this->request->getPost('id_kategori');
        if ($this->request->getPost('kategori_baru')) {
            $id_kategori = $kategoriModel->insert([
                'nama_kategori' => $this->request->getPost('kategori_baru')
            ], true);
        }

        $id_penulis = $this->request->getPost('id_penulis');
        if ($this->request->getPost('penulis_baru')) {
            $id_penulis = $penulisModel->insert([
                'nama_penulis' => $this->request->getPost('penulis_baru')
            ], true);
        }

        $id_penerbit = $this->request->getPost('id_penerbit');
        if ($this->request->getPost('penerbit_baru')) {
            $id_penerbit = $penerbitModel->insert([
                'nama_penerbit' => $this->request->getPost('penerbit_baru'),
                'alamat'        => $this->request->getPost('alamat_penerbit_baru')
            ], true);
        }

        $cover = $this->request->getFile('cover');
        $namaCover = null;

        if ($cover && $cover->isValid() && !$cover->hasMoved()) {
            $namaCover = $cover->getRandomName();
            $cover->move('uploads/buku', $namaCover);
        }

        $this->bukuModel->insert([
            'judul'         => $this->request->getPost('judul'),
            'isbn'          => $this->request->getPost('isbn'),
            'id_kategori'   => $id_kategori,
            'id_penulis'    => $id_penulis,
            'id_penerbit'   => $id_penerbit,
            'tahun_terbit'  => $this->request->getPost('tahun_terbit'),
            'jumlah'        => $this->request->getPost('jumlah'),
            'tersedia'      => $this->request->getPost('jumlah'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
            'cover'         => $namaCover
        ]);

        return redirect()->to('/buku')->with('success', 'Buku berhasil ditambahkan');
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $buku = $this->bukuModel->find($id);

        if (!$buku) {
            return redirect()->to('/buku')->with('error', 'Data buku tidak ditemukan');
        }

        return view('buku/edit', [
            'buku' => $buku,
            'kategori' => (new KategoriModel())->findAll(),
            'penulis'  => (new PenulisModel())->findAll(),
            'penerbit' => (new PenerbitModel())->findAll(),
            'rak'      => (new RakModel())->findAll(),
        ]);
    }

    // ================= UPDATE =================
    public function update($id)
    {
        $this->bukuModel->update($id, [
            'judul' => $this->request->getPost('judul'),
            'isbn'  => $this->request->getPost('isbn')
        ]);

        return redirect()->to('/buku')->with('success', 'Data berhasil diupdate');
    }

    // ================= DETAIL =================
    public function detail($id)
    {
        $buku = $this->bukuModel
            ->select('buku.*, kategori.nama_kategori, penulis.nama_penulis, penerbit.nama_penerbit, rak.nama_rak, rak.lokasi')
            ->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left')
            ->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left')
            ->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left')
            ->join('buku_rak', 'buku_rak.id_buku = buku.id_buku', 'left')
            ->join('rak', 'rak.id_rak = buku_rak.id_rak', 'left')
            ->where('buku.id_buku', $id)
            ->first();

        if (!$buku) {
            return redirect()->to('/buku')->with('error', 'Data tidak ditemukan');
        }

        return view('buku/detail', ['buku' => $buku]);
    }

    // ================= DELETE =================
    public function delete($id)
    {
        $buku = $this->bukuModel->find($id);

        if (!$buku) {
            return redirect()->to('/buku')->with('error', 'Data tidak ditemukan');
        }

        // hapus relasi dulu (biar gak error FK)
        $this->db->table('detail_peminjaman')
            ->where('id_buku', $id)
            ->delete();

        // hapus cover
        if (!empty($buku['cover']) && file_exists('uploads/buku/' . $buku['cover'])) {
            unlink('uploads/buku/' . $buku['cover']);
        }

        $this->bukuModel->delete($id);

        return redirect()->to('/buku')->with('success', 'Buku berhasil dihapus');
    }

    // ================= WA =================
    public function wa($id)
    {
        $buku = $this->bukuModel
            ->select('buku.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left')
            ->find($id);

        if (!$buku) {
            return redirect()->back()->with('error', 'Buku tidak ditemukan');
        }

        $text = "📚 INFO BUKU\n\n"
            . "Judul: {$buku['judul']}\n"
            . "ISBN: {$buku['isbn']}\n"
            . "Kategori: {$buku['nama_kategori']}\n"
            . "Stok: {$buku['tersedia']} / {$buku['jumlah']}";

        return redirect()->to("https://wa.me/?text=" . urlencode($text));
    }
}
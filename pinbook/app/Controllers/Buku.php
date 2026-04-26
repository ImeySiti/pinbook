<?php

namespace App\Controllers;

use App\Models\BukuModel;
use App\Models\KategoriModel;
use App\Models\PenulisModel;
use App\Models\PenerbitModel;
use App\Models\RakModel;
use App\Models\BukuRakModel;

class Buku extends BaseController
{
    protected $bukuModel;

    public function __construct()
    {
        $this->bukuModel = new BukuModel();
    }

    public function create()
    {
        $data = [
            'kategori' => (new KategoriModel())->findAll(),
            'penulis' => (new PenulisModel())->findAll(),
            'penerbit' => (new PenerbitModel())->findAll(),
            'rak' => (new RakModel())->findAll(),
        ];

        return view('buku/create', $data);
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $kategori = $this->request->getGet('kategori');

        $builder = $this->bukuModel
            ->select('buku.*, kategori.nama_kategori, penulis.nama_penulis, penerbit.nama_penerbit, rak.nama_rak, rak.lokasi')
            ->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left')
            ->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left')
            ->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left')
            ->join('buku_rak', 'buku_rak.id_buku = buku.id_buku', 'left')
            ->join('rak', 'rak.id_rak = buku_rak.id_rak', 'left');

        if ($keyword) {
            $builder->like('buku.judul', $keyword);
        }

        if ($kategori) {
            $builder->where('buku.id_kategori', $kategori);
        }

        $data['buku'] = $builder->paginate(10);
        $data['pager'] = $this->bukuModel->pager;
        $data['kategori'] = (new KategoriModel())->findAll();

        return view('buku/index', $data);
    }

    // ================= STORE =================
    public function store()
    {
        $kategoriModel = new KategoriModel();
        $penulisModel = new PenulisModel();
        $penerbitModel = new PenerbitModel();
        $bukuRakModel = new BukuRakModel();

        // ===== KATEGORI =====
        $id_kategori = $this->request->getPost('id_kategori');
        if ($this->request->getPost('kategori_baru')) {
            $id_kategori = $kategoriModel->insert([
                'nama_kategori' => $this->request->getPost('kategori_baru')
            ], true);
        }

        // ===== PENULIS =====
        $id_penulis = $this->request->getPost('id_penulis');
        if ($this->request->getPost('penulis_baru')) {
            $id_penulis = $penulisModel->insert([
                'nama_penulis' => $this->request->getPost('penulis_baru')
            ], true);
        }

        // ===== PENERBIT + ALAMAT =====
        $id_penerbit = $this->request->getPost('id_penerbit');
        $penerbit_baru = $this->request->getPost('penerbit_baru');
        $alamat_penerbit = $this->request->getPost('alamat_penerbit_baru');

        if (!empty($penerbit_baru)) {

            if (empty($alamat_penerbit)) {
                return redirect()->back()->withInput()->with('error', 'Alamat penerbit wajib diisi!');
            }

            $id_penerbit = $penerbitModel->insert([
                'nama_penerbit' => $penerbit_baru,
                'alamat' => $alamat_penerbit
            ], true);
        }

        // VALIDASI
        if (!$id_kategori || !$id_penulis || !$id_penerbit) {
            return redirect()->back()->withInput()->with('error', 'Kategori, Penulis, dan Penerbit wajib diisi!');
        }

        // ===== COVER =====
        $cover = $this->request->getFile('cover');
        $namaCover = null;

        if ($cover && $cover->isValid() && !$cover->hasMoved()) {
            $namaCover = $cover->getRandomName();
            $cover->move('uploads/buku', $namaCover);
        }

        // ===== SIMPAN BUKU =====
        $id_buku = $this->bukuModel->insert([
            'judul' => $this->request->getPost('judul'),
            'isbn' => $this->request->getPost('isbn'),
            'id_kategori' => $id_kategori,
            'id_penulis' => $id_penulis,
            'id_penerbit' => $id_penerbit,
            'tahun_terbit' => $this->request->getPost('tahun_terbit'),
            'jumlah' => $this->request->getPost('jumlah'),
            'tersedia' => $this->request->getPost('jumlah'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'cover' => $namaCover
        ], true);

        // ===== BUKU RAK =====
        if ($this->request->getPost('id_rak')) {
            $bukuRakModel->insert([
                'id_buku' => $id_buku,
                'id_rak' => $this->request->getPost('id_rak')
            ]);
        }

        return redirect()->to('/buku')->with('success', 'Buku berhasil ditambahkan');
    }

    // ================= UPDATE =================
    public function update($id)
    {
        $kategoriModel = new KategoriModel();
        $penulisModel = new PenulisModel();
        $penerbitModel = new PenerbitModel();
        $bukuRakModel = new BukuRakModel();

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

        // 🔥 FIX: tambah alamat juga di update
        $id_penerbit = $this->request->getPost('id_penerbit');
        if ($this->request->getPost('penerbit_baru')) {

            $id_penerbit = $penerbitModel->insert([
                'nama_penerbit' => $this->request->getPost('penerbit_baru'),
                'alamat' => $this->request->getPost('alamat_penerbit_baru')
            ], true);
        }

        $cover = $this->request->getFile('cover');
        $namaCover = $this->request->getPost('old_cover');

        if ($cover && $cover->isValid() && !$cover->hasMoved()) {
            $namaCover = $cover->getRandomName();
            $cover->move('uploads/buku', $namaCover);
        }

        $this->bukuModel->update($id, [
            'judul' => $this->request->getPost('judul'),
            'isbn' => $this->request->getPost('isbn'),
            'id_kategori' => $id_kategori,
            'id_penulis' => $id_penulis,
            'id_penerbit' => $id_penerbit,
            'tahun_terbit' => $this->request->getPost('tahun_terbit'),
            'jumlah' => $this->request->getPost('jumlah'),
            'tersedia' => $this->request->getPost('tersedia'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'cover' => $namaCover
        ]);

        if ($this->request->getPost('id_rak')) {
            $bukuRakModel->where('id_buku', $id)->delete();

            $bukuRakModel->insert([
                'id_buku' => $id,
                'id_rak' => $this->request->getPost('id_rak')
            ]);
        }

        return redirect()->to('/buku')->with('success', 'Buku berhasil diupdate');
    }

    public function delete($id)
    {
        $this->bukuModel->delete($id);
        return redirect()->to('/buku');
    }
}
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

        $data = [
            'buku'     => $builder->paginate(10),
            'pager'    => $this->bukuModel->pager,
            'kategori' => (new KategoriModel())->findAll()
        ];

        return view('buku/index', $data);
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

        // kategori
        $id_kategori = $this->request->getPost('id_kategori');
        if ($this->request->getPost('kategori_baru')) {
            $id_kategori = $kategoriModel->insert([
                'nama_kategori' => $this->request->getPost('kategori_baru')
            ], true);
        }

        // penulis
        $id_penulis = $this->request->getPost('id_penulis');
        if ($this->request->getPost('penulis_baru')) {
            $id_penulis = $penulisModel->insert([
                'nama_penulis' => $this->request->getPost('penulis_baru')
            ], true);
        }

        // penerbit
        $id_penerbit = $this->request->getPost('id_penerbit');
        if ($this->request->getPost('penerbit_baru')) {
            $id_penerbit = $penerbitModel->insert([
                'nama_penerbit' => $this->request->getPost('penerbit_baru'),
                'alamat'        => $this->request->getPost('alamat_penerbit_baru')
            ], true);
        }

        // cover
        $cover = $this->request->getFile('cover');
        $namaCover = null;

        if ($cover && $cover->isValid() && !$cover->hasMoved()) {
            $namaCover = $cover->getRandomName();
            $cover->move('uploads/buku', $namaCover);
        }

        // SIMPAN BUKU (FIX BUG: HAPUS DOUBLE INSERT!)
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
    public function edit($id)
{
    $buku = $this->bukuModel
        ->select('buku.*')
        ->find($id);

    if (!$buku) {
        return redirect()->to('/buku')->with('error', 'Data buku tidak ditemukan');
    }

    $data = [
        'buku' => $buku,
        'kategori' => (new \App\Models\KategoriModel())->findAll(),
        'penulis'  => (new \App\Models\PenulisModel())->findAll(),
        'penerbit' => (new \App\Models\PenerbitModel())->findAll(),
        'rak'      => (new \App\Models\RakModel())->findAll(),
    ];

    return view('buku/edit', $data);
}

public function update($id)
{
    $model = new BukuModel();

    $data = [
        'judul' => $this->request->getPost('judul'),
        'penulis' => $this->request->getPost('penulis'),
    ];

    $model->update($id, $data);

    return redirect()->to('/buku');
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
            . "Stok: {$buku['tersedia']} / {$buku['jumlah']}\n";

        $wa = "https://wa.me/?text=" . urlencode($text);

        return redirect()->to($wa);
    }

    // ================= PRINT =================
   public function print()
{
    $keyword  = $this->request->getGet('keyword');
    $kategori = $this->request->getGet('kategori');

    $builder = $this->bukuModel
        ->select('buku.*, 
                  kategori.nama_kategori, 
                  penulis.nama_penulis, 
                  penerbit.nama_penerbit,
                  rak.nama_rak')
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

    return view('buku/print', [
        'buku' => $builder->findAll()
    ]);
}
public function detail($id)
{
    $buku = $this->bukuModel
        ->select('buku.*, 
                  kategori.nama_kategori, 
                  penulis.nama_penulis, 
                  penerbit.nama_penerbit,
                  rak.nama_rak,
                  rak.lokasi')
        ->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left')
        ->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left')
        ->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left')
        ->join('buku_rak', 'buku_rak.id_buku = buku.id_buku', 'left')
        ->join('rak', 'rak.id_rak = buku_rak.id_rak', 'left')
        ->where('buku.id_buku', $id)
        ->first();

    if (!$buku) {
        return redirect()->to('/buku')
            ->with('error', 'Data buku tidak ditemukan');
    }

    return view('buku/detail', [
        'buku' => $buku
    ]);
}

    // ================= DELETE =================
    public function delete($id)
    {
        $this->bukuModel->delete($id);
        return redirect()->to('/buku')->with('success', 'Buku berhasil dihapus');
    }
}
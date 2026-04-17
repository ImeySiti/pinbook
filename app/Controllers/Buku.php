<?php

namespace App\Controllers;

use App\Models\BukuModel;

class Buku extends BaseController
{
    protected $buku;
    protected $db;

    public function __construct()
    {
        $this->buku = new BukuModel();
        $this->db = \Config\Database::connect();
    }

    // =========================
    // INDEX
    // =========================
    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        $builder = $this->db->table('buku');

        $builder->select('
            buku.*,
            kategori.nama_kategori,
            penulis.nama_penulis,
            penerbit.nama_penerbit,
            rak.nama_rak,
            rak.lokasi
        ');

        $builder->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left');
        $builder->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left');
        $builder->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left');
        $builder->join('buku_rak', 'buku_rak.id_buku = buku.id_buku', 'left');
        $builder->join('rak', 'rak.id_rak = buku_rak.id_rak', 'left');

        if ($keyword) {
            $builder->like('buku.judul', $keyword);
        }

        $builder->groupBy('buku.id_buku');

        $data['buku'] = $builder->get()->getResultArray();

        return view('buku/index', $data);
    }

    // =========================
    // CREATE
    // =========================
    public function create()
    {
        $data['kategori'] = $this->db->table('kategori')->get()->getResultArray();
        $data['penulis']  = $this->db->table('penulis')->get()->getResultArray();
        $data['penerbit'] = $this->db->table('penerbit')->get()->getResultArray();
        $data['rak']      = $this->db->table('rak')->get()->getResultArray();

        return view('buku/create', $data);
    }

    // =========================
    // STORE
    // =========================
    public function store()
    {
        $rules = [
            'judul' => 'required',
            'cover' => 'max_size[cover,2048]|ext_in[cover,jpg,jpeg,png,pdf]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal');
        }

        $data = $this->request->getPost();

        $rakInput = $this->request->getPost('id_rak');
        $id_rak = null;

        if ($rakInput) {
            if (is_numeric($rakInput)) {
                $id_rak = $rakInput;
            } else {
                $cek = $this->db->table('rak')
                    ->where('nama_rak', $rakInput)
                    ->get()
                    ->getRowArray();

                if ($cek) {
                    $id_rak = $cek['id_rak'];
                } else {
                    $this->db->table('rak')->insert([
                        'nama_rak' => $rakInput,
                        'lokasi' => '-'
                    ]);

                    $id_rak = $this->db->insertID();
                }
            }
        }

        $file = $this->request->getFile('cover');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $file->move('uploads/buku/', $namaFile);
            $data['cover'] = $namaFile;
        }

        $this->buku->insert($data);
        $id_buku = $this->buku->getInsertID();

        if ($id_rak) {
            $this->db->table('buku_rak')->insert([
                'id_buku' => $id_buku,
                'id_rak' => $id_rak
            ]);
        }

        return redirect()->to('/buku');
    }

    // =========================
    // DETAIL
    // =========================
    public function detail($id)
    {
        $builder = $this->db->table('buku');

        $builder->select('
            buku.*,
            kategori.nama_kategori,
            penulis.nama_penulis,
            penerbit.nama_penerbit,
            rak.nama_rak,
            rak.lokasi
        ');

        $builder->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left');
        $builder->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left');
        $builder->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left');
        $builder->join('buku_rak', 'buku_rak.id_buku = buku.id_buku', 'left');
        $builder->join('rak', 'rak.id_rak = buku_rak.id_rak', 'left');

        $builder->where('buku.id_buku', $id);

        $data['buku'] = $builder->get()->getRowArray();

        return view('buku/detail', $data);
    }

    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {
        $data['buku'] = $this->buku->find($id);
        $data['kategori'] = $this->db->table('kategori')->get()->getResultArray();
        $data['penulis'] = $this->db->table('penulis')->get()->getResultArray();
        $data['penerbit'] = $this->db->table('penerbit')->get()->getResultArray();
        $data['rak'] = $this->db->table('rak')->get()->getResultArray();

        return view('buku/edit', $data);
    }

    // =========================
    // UPDATE
    // =========================
    public function update($id)
    {
        $data = $this->request->getPost();

        $file = $this->request->getFile('cover');

        if ($file && $file->isValid() && !$file->hasMoved()) {

            $buku = $this->buku->find($id);

            if (!empty($buku['cover']) && file_exists('uploads/buku/' . $buku['cover'])) {
                unlink('uploads/buku/' . $buku['cover']);
            }

            $namaFile = $file->getRandomName();
            $file->move('uploads/buku/', $namaFile);

            $data['cover'] = $namaFile;
        }

        $this->buku->update($id, $data);

        $id_rak = $data['id_rak'] ?? null;

        $cek = $this->db->table('buku_rak')
            ->where('id_buku', $id)
            ->get()
            ->getRowArray();

        if ($cek) {
            $this->db->table('buku_rak')
                ->where('id_buku', $id)
                ->update(['id_rak' => $id_rak]);
        } else {
            if ($id_rak) {
                $this->db->table('buku_rak')->insert([
                    'id_buku' => $id,
                    'id_rak' => $id_rak
                ]);
            }
        }

        return redirect()->to('/buku');
    }

    // =========================
    // DELETE
    // =========================
    public function delete($id)
    {
        $buku = $this->buku->find($id);

        if (!empty($buku['cover']) && file_exists('uploads/buku/' . $buku['cover'])) {
            unlink('uploads/buku/' . $buku['cover']);
        }

        $this->db->table('buku_rak')->where('id_buku', $id)->delete();
        $this->buku->delete($id);

        return redirect()->to('/buku');
    }

    // =========================
    // PRINT (SEMUA BUKU)
    // =========================
    public function print()
    {
        $data['buku'] = $this->db->table('buku')
            ->select('buku.*, kategori.nama_kategori, penulis.nama_penulis, penerbit.nama_penerbit')
            ->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left')
            ->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left')
            ->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left')
            ->get()->getResultArray();

        return view('buku/print', $data);
    }

    // =========================
    // WHATSAPP (PER BUKU)
    // =========================
    public function wa($id)
    {
        $buku = $this->db->table('buku')
            ->select('buku.*, kategori.nama_kategori, penulis.nama_penulis, penerbit.nama_penerbit, rak.nama_rak')
            ->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left')
            ->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left')
            ->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left')
            ->join('buku_rak', 'buku_rak.id_buku = buku.id_buku', 'left')
            ->join('rak', 'rak.id_rak = buku_rak.id_rak', 'left')
            ->where('buku.id_buku', $id)
            ->get()
            ->getRowArray();

        $pesan = "DATA BUKU\n\n";
        foreach ($buku as $key => $value) {
            $pesan .= strtoupper($key) . ": " . $value . "\n";
        }

        $noWa = "6285175017991";

        return redirect()->to("https://wa.me/" . $noWa . "?text=" . urlencode($pesan));
    }
}
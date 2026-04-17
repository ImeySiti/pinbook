<?php

namespace App\Controllers;

use App\Models\KategoriModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Kategori extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Kategori',
            'kategori' => $this->kategoriModel->getKategoriPaginated(10),
            'pager' => $this->kategoriModel->pager
        ];

        return view('kategori/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Kategori Baru',
            'validation' => \Config\Services::validation()
        ];

        return view('kategori/create', $data);
    }

    public function store()
    {
        if (!$this->validateData()) {
            return redirect()->back()->withInput();
        }

        $data = $this->request->getPost('nama_kategori');

        $this->kategoriModel->insert($data);

        return redirect()->to('/kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit($id = null)
    {
        $kategori = $this->kategoriModel->find($id);

        if (!$kategori) {
            throw new PageNotFoundException('Kategori tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Kategori',
            'kategori' => $kategori,
            'validation' => \Config\Services::validation()
        ];

        return view('kategori/edit', $data);
    }

    public function update($id = null)
    {
        $kategori = $this->kategoriModel->find($id);

        if (!$kategori) {
            throw new PageNotFoundException('Kategori tidak ditemukan.');
        }

        if (!$this->validateData($id)) {
            return redirect()->to("/kategori/edit/$id")->withInput();
        }

        $data = $this->request->getPost('nama_kategori');

        $this->kategoriModel->update($id, $data);

        return redirect()->to('/kategori')->with('success', 'Kategori berhasil diupdate!');
    }

    public function delete($id = null)
    {
        $kategori = $this->kategoriModel->find($id);

        if (!$kategori) {
            throw new PageNotFoundException('Kategori tidak ditemukan.');
        }

        $this->kategoriModel->delete($id);

        return redirect()->to('/kategori')->with('success', 'Kategori berhasil dihapus!');
    }

    private function validateData($id = null)
    {
        $rules = [
            'nama_kategori' => 'required|min_length[3]|max_length[100]'
        ];

        // Tambahkan unique rule kecuali saat edit
        if ($id) {
            $rules['nama_kategori'] .= "|is_unique[kategori.nama_kategori,id_kategori,$id]";
        } else {
            $rules['nama_kategori'] .= "|is_unique[kategori.nama_kategori]";
        }

        return $this->validate($rules);
    }
}
<?php

namespace App\Controllers;

use App\Models\KategoriModel;

class Kategori extends BaseController
{
    protected $kategori;

    public function __construct()
    {
        $this->kategori = new KategoriModel();
    }

   public function index()
{
    $keyword = $this->request->getGet('keyword');

    $kategoriModel = new \App\Models\KategoriModel();

    if ($keyword) {
        $kategori = $kategoriModel
            ->like('nama_kategori', $keyword)
            ->findAll();
    } else {
        $kategori = $kategoriModel->findAll();
    }

    return view('kategori/index', [
        'kategori' => $kategori,
        'keyword'  => $keyword
    ]);
}

    public function create()
    {
        return view('kategori/create');
    }

    public function store()
    {
        $this->kategori->save([
            'nama_kategori' => $this->request->getPost('nama_kategori')
        ]);

        return redirect()->to('/kategori');
    }

    public function edit($id)
    {
        $data = [
            'kategori' => $this->kategori->find($id)
        ];

        return view('kategori/edit', $data);
    }

    public function update($id)
    {
        $this->kategori->update($id, [
            'nama_kategori' => $this->request->getPost('nama_kategori')
        ]);

        return redirect()->to('/kategori');
    }

    public function delete($id)
    {
        $this->kategori->delete($id);
        return redirect()->to('/kategori');
    }
}